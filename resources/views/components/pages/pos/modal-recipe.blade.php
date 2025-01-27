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
     * HTML Templates
     */
    const templatesRecipe = {
        updateTableListItem: (data) => {
            const tbody = $("#table-body-product-recipe");

            if (!Array.isArray(data) || data?.length === 0) {
                tbody.html(table.emptyTable());
                return;
            }

            $("#label_empty_data")?.remove();
            tbody.empty();
            tbody.append(data.map((product) => templatesRecipe.tableRowProduct(product)).join(""));
            debug.log("UpdateTable", "Table updated successfully");
        },

        tableRowProduct: (product) => `
            <tr id="list_product_${product.product.id}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${utils.escapeHtml(product.product.name || '-')}
                </th>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <div class="flex justify-center items-center gap-1">
                        <i class="fa-solid fa-minus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-minus-product-${product.product.id}"></i>
                        <input type="number" name="product_total_${product.product.id}" id="product_total_${product.product.id}"
                            required min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Jumlah" value="${product.qty}">
                        <i class="fa-solid fa-plus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-plus-product-${product.product.id}"></i>
                    </div>
                    <input type="hidden" name="product_id_${product.product.id}" id="product_id_${product.product.id}"
                        value="${product.product.id}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <select name="product_unit_${product.product.id}" id="product_unit_${product.product.id}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="${product.product.largest_unit.id}" ${
                            product.product.largest_unit.id === product.unit?.id ? 'selected' : ''
                        }>${product.product.largest_unit.symbol}</option>
                        <option value="${product.product.smallest_unit.id}"
                            ${product.product.smallest_unit.id === product.unit?.id ? 'selected' : ''}
                        >${product.product.smallest_unit.symbol}</option>
                    </select>
                    <input type="hidden" name="product_conversion_${product.product.id}" id="product_conversion_${product.product.id}"
                        value="${product.product.conversion_value}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_price_${product.product.id}" id="product_price_${product.product.id}"
                        required readonly
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Harga" value="${UIManager.formatCurrency(product.price)}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_tuslah_${product.product.id}" id="product_tuslah_${product.product.id}"
                        required readonly
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Tuslah" value="${UIManager.formatCurrency(product.tuslah)}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_discount_${product.product.id}" id="product_discount_${product.product.id}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Diskon" value="${
                            product.discount_type === 'Percentage' ?
                                product.discount + '%' :
                                UIManager.formatCurrency(product.discount)
                        }">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_subtotal_${product.product.id}" id="product_subtotal_${product.product.id}" required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Sub Total" readonly value="${UIManager.formatCurrency(product.subtotal)}">
                </td>
                <td class="px-3 py-2 flex gap-2 items-center">
                    <button
                        id="btn-delete-product-${product.product.id}"
                        class="font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md"
                        data-id="${product.product.id}"
                        type="button"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        `,
    };

    /**
     * Data Fetching and Processing
     */
    const dataServiceRecipe = {
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
                    // Improved error checking
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    LIST_DATA = response.data;
                    dataServiceRecipe.processAndRenderRecipes(response.data);
                },
                error: (xhr, status, error) => {
                    // More robust error handling
                    console.error('Fetch error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal mengambil data resep',
                        icon: 'error'
                    });
                },
                complete: () => {
                    $('#modal-recipe form').find('.absolute').remove();
                },
            });
        },

        processAndRenderRecipes: (recipes) => {
            const recipeContainer = $('#recipe-list-container');
            recipeContainer.empty();

            if (recipes && recipes.length > 0) {
                recipes.forEach(recipe => {
                    const recipeItem = dataServiceRecipe.createRecipeItem(recipe);
                    recipeContainer.append(recipeItem);
                });
            } else {
                recipeContainer.append(`
                <div class="text-center py-4 text-gray-500">
                    Tidak ada resep ditemukan
                </div>
            `);
            }
        },

        createRecipeItem: (recipe) => `
        <div class="flex gap-3 items-center justify-between border-y py-3 px-2">
            <div>
                <p class="text-xs font-semibold text-gray-900">
                    ${utils.escapeHtml(recipe.name)}
                </p>
                <div class="flex gap-1.5 items-center text-xs text-gray-600">
                    <div class="flex items-center">
                        ${utils.escapeHtml(recipe.customer_name || "-")}(${recipe.customer_age || "-"}Thn)
                    </div>
                    |
                    <div class="flex items-center">
                        ${utils.escapeHtml(recipe.doctor_name || "-")}(${recipe.doctor_sip || "-"})
                    </div>
                </div>
            </div>
            <x-button color="blue" size="sm" data-recipe-id="${recipe.id}" id="btn-select-recipe">
                Pilih
            </x-button>
        </div>
    `
    };

    /**
     * Event Handlers
     */
    const eventHandlersRecipe = {
        init: () => {
            // Debounce search with improved timeout handling
            let searchTimeout;
            $('#search-recipe').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    const searchValue = $(this).val();
                    dataServiceRecipe.fetchData(searchValue);
                }, DEBOUNCE_DELAY);
            });

            // Modal open handler
            $('[data-modal-target="modal-recipe"]').on('click', () => {
                dataServiceRecipe.fetchData();
            });

            // Select recipe handler with improved validation
            $('#recipe-list-container').on('click', '#btn-select-recipe', function() {
                const recipeId = $(this).attr('data-recipe-id');
                const selectedData = LIST_DATA.find(data => data.id == recipeId);

                if (!selectedData) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Resep tidak ditemukan',
                        icon: 'error'
                    });
                    return;
                }

                const products = selectedData?.products || [];
                const unit = selectedData?.unit?.id;

                const invalidProducts = products.filter(product => {
                    if (product?.largest_unit === unit) {
                        return product.qty > product.product.largest_stock;
                    } else {
                        return product.qty > product.product.stock;
                    }
                });

                if (invalidProducts.length === 0) {
                    $('#recipe').attr('data-id', recipeId).text(selectedData?.name);
                    document.querySelector('[data-modal-target="modal-recipe"]').click();
                    templatesRecipe.updateTableListItem(products);
                    priceCalculationsPOS.calculateAllProductRows(products);
                } else {
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
                    });
                }
            });

            // Keyboard shortcut handler
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
