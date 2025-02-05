<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div id="recipe-list" class="flex flex-col gap-4 w-full">
        {{-- Search --}}
        <form method="POST">
            @csrf
            <div class="relative sm:w-full md:w-1/2 lg:w-2/6">
                <input type="search" id="search-recipe" name="search-recipe"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama resep" />
                <button type="button" id="search-button"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Staff</th>
                        <th scope="col" class="px-6 py-3">Nama Pelanggan</th>
                        <th scope="col" class="px-6 py-3">Usia Pelanggan</th>
                        <th scope="col" class="px-6 py-3">Nama Dokter</th>
                        <th scope="col" class="px-6 py-3">SIP Dokter</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    {{-- Table content will be inserted here --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs md:text-sm">
            <div class="data-info"></div>
            <div class="pagination-container"></div>
        </div>
    </div>

    {{-- Modals --}}
    <span data-modal-target="modal-delete" data-modal-toggle="modal-delete" class="hidden"></span>
    <x-global.modal-delete name="resep" />
</x-layout>

<script>
    /**
     * Recipe Management Module
     * Handles the display, pagination, and interaction with Recipe data in a table format
     */

    // Constants
    const PAGINATION_DISPLAY_RANGE = 2;
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 10;
    const TEXT_TRUNCATE_LENGTH = 40;

    /**
     * Data Fetching and Processing
     */
    const dataServiceRecipe = {
        fetchData: (page = 1, search = '') => {
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/pharmacy/recipe/list',
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: PER_PAGE
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }
                    await uiManager.refreshUI(response);

                    setTimeout(() => {
                        const modalDelete = new Modal(document.getElementById(
                            'modal-delete'));

                        document.querySelectorAll('[data-modal-toggle="modal-delete"]')
                            .forEach(button => {
                                button.addEventListener('click', () => {
                                    modalDelete.show();
                                });
                            });
                    }, 100);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError(
                        'Gagal mengambil data recipe. Silahkan coba lagi.');
                },
            });
        },

        deleteRecipe: (id) => {
            $("#recipe-list").prepend(uiManager.showScreenLoader());
            $.ajax({
                url: `/inventory/pharmacy/recipe/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Berhasil menghapus data",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Fetch data again
                    const params = urlManager.getParams();
                    dataServiceRecipe.fetchData(params.page, params.search);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            });
        }
    };

    /**
     * HTML Templates
     */
    const templates = {
        tableRow: (recipe) => `<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${recipe?.name || '-'}
                </th>
                <td class="px-6 py-4">
                    ${recipe?.staff?.name || '-'}
                </td>
                <td class="px-6 py-4">
                    ${recipe?.customer_name || '-'}
                </td>
                <td class="px-6 py-4">
                    ${recipe?.customer_age || 0}
                </td>
                <td class="px-6 py-4">
                    ${recipe?.doctor_name || '-'}
                </td>
                <td class="px-6 py-4">
                    ${recipe?.doctor_sip || '-'}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    <a href="/inventory/pharmacy/recipe/view/${recipe?.id}">
                        <x-button type="button">
                            <i class="fa-solid fa-info"></i>
                        </x-button>
                    </a>
                    <x-button
                        type="button"
                        id="btn-delete-recipe"
                        data-id="${recipe?.id}"
                        color="red"
                        data-modal-target="modal-delete"
                        data-modal-toggle="modal-delete"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </x-button>
                </td>
            </tr>`,
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
                const search = $('#search-recipe').val();

                urlManager.updateParams({
                    page: 1,
                    search,
                });

                dataServiceRecipe.fetchData(1, search);
            };

            // Search input handler
            let searchTimeout;
            $('#search-recipe').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    handleFilterChange();
                }, DEBOUNCE_DELAY);
            });

            // Delete confirmation handler
            $("body").on('click', '#btn-delete-recipe', function() {
                let recipe_id = $(this).data('id');

                // Get recipe name from the same row
                let recipe_name = $(this).closest('tr').find('th').text().trim();

                // Update modal content
                $('#modal-delete h3').text(
                    `Apakah anda yakin ingin menghapus data ${recipe_name} ini?`);

                // Update onclick attribute of confirm delete button
                $('#modal-delete button[data-modal-hide="modal-delete"].bg-red-600').attr('onclick',
                    `dataServiceRecipe.deleteRecipe(${recipe_id})`);
            });

            // Pagination click handler
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const search = $('#search-recipe').val();

                debug.log('Pagination', `Changing to page ${page}`);
                urlManager.updateParams({
                    page,
                    search,
                });

                dataServiceRecipe.fetchData(page, search);
            });
        },
    };

    /**
     * Initialize the recipe table functionality
     */
    function initRecipeTable() {
        debug.log('Init', 'Initializing recipe table...');
        const params = urlManager.getParams();
        const form = $('form');

        // Set initial values for all filters
        form.find('input[name="search-recipe"]').val(params.search || '');

        // Initial data fetch with all parameters
        dataServiceRecipe.fetchData(
            params.page || 1,
            params.search || '',
        );
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initRecipeTable();
        eventHandlersRecipe.init();

        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
