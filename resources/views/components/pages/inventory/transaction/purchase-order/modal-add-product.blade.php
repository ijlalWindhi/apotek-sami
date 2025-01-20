{{-- Modal --}}
<div id="modal-add-product" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-7xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Cari Produk
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-product">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="w-full p-4">
                <div class="relative sm:w-full md:w-1/2 lg:w-2/6">
                    <input type="search" id="search-name"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Cari nama, sku" />
                    <button type="button" id="search-button"
                        class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg pb-6">
                <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Tipe</th>
                            <th scope="col" class="px-6 py-3">SKU</th>
                            <th scope="col" class="px-6 py-3 min-w-48">Harga</th>
                            <th scope="col" class="px-6 py-3">Stok</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-product">
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Modal Add Product
     * Handles the modal for adding product to purchase order
     */

    // Constants
    const PAGINATION_DISPLAY_RANGE = 2;
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 10;
    const TEXT_TRUNCATE_LENGTH = 40;

    /**
     * Data Fetching and Processing
     */
    const dataServiceProduct = {
        /**
         * Fetches tax data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (page = 1, search = '') => {
            uiManager.showLoading("#table-body-product");

            $.ajax({
                url: '/inventory/pharmacy/product/list',
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: PER_PAGE,
                    is_active: 1,
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }
                    await uiManager.refreshUI(response, "#table-body-product");
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data pajak. Silahkan coba lagi.');
                },
            });
        },

        getDetail: (productId) => {
            uiManager.showLoading("#table-body-product");

            $.ajax({
                url: `/inventory/pharmacy/product/${productId}`,
                method: 'GET',
                contentType: 'application/json',
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    await templates.updateTableListItem([response.data]);

                    // close modal
                    document.querySelector('[data-modal-target="modal-add-product"]').click();
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data pajak. Silahkan coba lagi.');
                },
            });
        },
    };

    /**
     * HTML Templates
     */
    const templates = {
        updateTableListItem: (data) => {
            debug.log("UpdateTableListItem", "Starting table update");
            const tbody = $("#table-body");

            if (!Array.isArray(data) || data.length === 0) {
                tbody.html(table.emptyTable());
                return;
            }

            tbody.html(data.map((product) => templates.tableRowProduct(product)).join(""));
            debug.log("UpdateTable", "Table updated successfully");
        },

        tableRow: (product) => `
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${utils.escapeHtml(product.name || '-')}
                </th>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    ${utils.escapeHtml(product.type || '-')}
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    ${utils.escapeHtml(product.sku || '-')}
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col justify-start items-start">
                        <div class="flex gap-2">
                            <p class="w-20">Harga Beli</p>
                            ${product.purchase_price ? `: Rp${new Intl.NumberFormat('id-ID').format(product.purchase_price)}` : '0'}
                        </div>
                        <div class="flex gap-2">
                            <p class="w-20">Harga Jual</p>
                            ${product.purchase_price ? `: Rp${new Intl.NumberFormat('id-ID').format(product.selling_price)}` : '0'}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    ${product.stock || 0}
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    ${product.is_active ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Dijual</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Tidak Dijual</span>'}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    ${templates.actionButtons(product.id)}
                </td>
            </tr>
        `,

        tableRowProduct: (product) => `
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${utils.escapeHtml(product.name || '-')}
                </th>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400" id="product_description_${product.id}">
                    ${utils.escapeHtml(product.description || '-')}
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 w-full">
                    <div class="flex justify-center items-center gap-1">
                        <i class="fa-solid fa-minus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-minus-product-${product.id}"></i>
                        <input type="number" name="product_total_${product.id}" id="product_total_${product.id}"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Jumlah">
                        <i class="fa-solid fa-plus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-plus-product-${product.id}"></i>
                    </div>
                    <input type="hidden" name="product_id_${product.id}" id="product_id_${product.id}"
                        value="${product.id}">
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    ${product.unit?.name || '-'}
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_price_${product.id}" id="product_price_${product.id}"
                        required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Harga" value="${UIManager.formatCurrency(product.purchase_price)}">
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_discount_${product.id}" id="product_discount_${product.id}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Diskon">
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_subtotal_${product.id}" id="product_subtotal_${product.id}" required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                        placeholder="Sub Total" readonly>
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    <button
                        id="btn-delete-product-${product.id}"
                        class="font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md"
                        data-id="${product.id}"
                        type="button"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        `,

        actionButtons: (id) => `
            <button
                id="btn-add-product"
                class="font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md"
                data-id="${id}"
            >
                <i class="fa-solid fa-plus"></i>
            </button>
        `,

        loadingModal: '<div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90"><i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i></div>',
    };

    /**
     * Event Handlers
     */
    const eventHandlersProduct = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Search input handler with debounce
            let searchTimeout;
            $('#search-name').on('input', function() {
                const searchValue = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    urlManager.updateParams({
                        search: searchValue,
                        page: 1
                    });
                    dataServiceProduct.fetchData(1, searchValue);
                }, DEBOUNCE_DELAY);
            });

            // Pagination click handler
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const currentSearch = $('#search-name').val();

                debug.log('Pagination', `Changing to page ${page}`);
                urlManager.updateParams({
                    page,
                    search: currentSearch
                });
                dataServiceProduct.fetchData(page, currentSearch);
            });

            // Browser navigation handler
            window.addEventListener('popstate', function() {
                const params = urlManager.getParams();
                $('#search-name').val(params.search);
                dataServiceProduct.fetchData(params.page, params.search);
            });

            // Modal open
            $(document).on('click', '[data-modal-toggle="modal-add-product"]', function() {
                initProductTable();
            });

            // Add product button
            $(document).on('click', '#btn-add-product', function() {
                const productId = $(this).data('id');
                dataServiceProduct.getDetail(productId);
            });
        },
    };

    /**
     * Initialize the product table functionality
     */
    function initProductTable() {
        debug.log('Init', 'Initializing product table...');
        const params = urlManager.getParams();
        $('#search-name').val(params.search);
        dataServiceProduct.fetchData(params.page, params.search);
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersProduct.init();
    });
</script>
