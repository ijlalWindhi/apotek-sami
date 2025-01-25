@props(['users'])

<button data-modal-target="modal-recipe" data-modal-toggle="modal-recipe" class="hide"></button>

<div id="modal-recipe" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between py-1 px-5 border-b rounded-t dark:border-gray-600">
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    Resep
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-recipe">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="flex justify-between items-center gap-2 py-3 px-4">
                <form class="w-full">
                    @csrf
                    <div class="relative w-full">
                        <input type="search" id="search-recipe" name="search-recipe"
                            class="block px-2.5 py-1.5 w-full z-20 text-xs text-gray-900 bg-gray-50 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="Cari nama resep" />
                        <button type="button" id="btn-search-recipe"
                            class="absolute top-0 end-0 px-2.5 py-1.5 text-xs font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </form>
                <x-pages.pos.modal-add-recipe :users="$users"></x-pages.pos.modal-add-recipe>
            </div>
            <div id="recipe-list-container" class="flex flex-col px-4 py-3 h-full max-h-[50vh] overflow-y-auto">
                <!-- Recipe list will be populated here -->
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Recipe Modal
     * Handles all JavaScript functionalities for the Recipe modal
     */
    let LIST_DATA = [];

    /**
     * Data Fetching and Processing
     */
    const dataServiceRecipe = {
        /**
         * Fetch data from the server
         * @param {string} search
         */
        fetchData: (search = '') => {
            $('#modal-recipe form').prepend(templates.loadingModal);
            $.ajax({
                url: '/pos/recipe/list',
                method: 'GET',
                data: {
                    page: 1,
                    per_page: 9999999,
                    search,
                },
                success: (response) => {
                    // Check response validity
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }
                    LIST_DATA = response.data;

                    // Clear existing recipe list
                    const recipeContainer = $('#recipe-list-container');
                    recipeContainer.empty();

                    // Populate recipe list
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(recipe => {
                            const recipeItem = `
                                <div class="flex gap-3 items-center justify-between border-y py-3 px-2">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">
                                            ${recipe.name}
                                        </p>
                                        <div class="flex gap-1.5 items-center text-xs text-gray-600">
                                            <div class="flex items-center">
                                                ${recipe.customer_name || "-"}(${recipe.customer_age || "-"}Thn)
                                            </div>
                                            |
                                            <div class="flex items-center">
                                                ${recipe.doctor_name || "-"}(${recipe.doctor_sip || "-"})
                                            </div>
                                        </div>
                                    </div>
                                    <x-button color="blue" size="sm" data-recipe-id="${recipe.id}" id="btn-select-recipe">
                                        Pilih
                                    </x-button>
                                </div>
                            `;
                            recipeContainer.append(recipeItem);
                        });
                    } else {
                        // Handle empty results
                        recipeContainer.append(`
                            <div class="text-center py-4 text-gray-500">
                                Tidak ada resep ditemukan
                            </div>
                        `);
                    }
                },
                error: (xhr, status, error) => {
                    // Handle fetch error
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    $('#modal-recipe form').find('.absolute').remove();
                },
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlersRecipe = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Common function to handle all filter changes
            const handleFilterChange = () => {
                const searchValue = $('#search-recipe').val();
                dataServiceRecipe.fetchData(searchValue);
            };

            // Faktur input handler with debounce
            let searchTimeout;
            $('#search-recipe').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    handleFilterChange();
                }, DEBOUNCE_DELAY);
            });

            // Modal open handler
            $('[data-modal-target="modal-recipe"]').on('click', function() {
                dataServiceRecipe.fetchData();
            });

            // Select recipe handler
            $('#recipe-list-container').on('click', '#btn-select-recipe', function() {
                const recipeId = $(this).attr('data-recipe-id');
                const selectedData = LIST_DATA.find(data => data.id == recipeId);

                // Validate stock product with selected recipe
                const products = selectedData?.products;
                const unit = selectedData?.unit?.id;
                const invalidProducts = (products || []).filter(product => {
                    if (product?.largest_unit === unit) {
                        return product.qty > product.product.largest_stock;
                    } else {
                        return product.qty > product.product.stock;
                    }
                });

                if (invalidProducts.length === 0) {
                    // Trigger event to add recipe to the list
                    $('#recipe').attr('data-id', recipeId).text(selectedData?.name);

                    document.querySelector('[data-modal-target="modal-recipe"]').click();
                } else {
                    // Show warning modal
                    Swal.fire({
                        title: 'Peringatan',
                        html: `
                            <p class="text-sm">Beberapa produk pada resep ini melebihi stok yang ada.</p>
                            <ul class="text-left text-xs my-1">
                                ${invalidProducts.map(product => `<li>- ${product.product.name} (${product.qty} ${product.unit.name})</li>`).join('')}
                            </ul>
                            <p class="text-sm">Silahkan anda membuat resep baru!</p>
                        `,
                        icon: 'warning',
                    })
                }
            });

            // Open modal on Ctrl + Alt + R
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'r') {
                    event.preventDefault();
                    document.querySelector('[data-modal-target="modal-recipe"]').click();
                }
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersRecipe.init();
    });
</script>
