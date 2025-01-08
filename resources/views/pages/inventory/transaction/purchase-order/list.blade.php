<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search & Add Button --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="relative sm:w-full md:w-1/2 lg:w-2/6">
                <input type="search" id="search-name-product" name="search-name-product"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama, sku" />
                <button type="button" id="search-button"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>

            <a href="{{ route('purchaseOrder.create') }}">
                <x-button color="blue">
                    <i class="fa-solid fa-plus"></i>
                    <span class="ms-2">Tambah</span>
                </x-button>
            </a>
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 min-w-40">No. Faktur</th>
                        <th scope="col" class="px-6 py-3 min-w-44">Faktur Supplier</th>
                        <th scope="col" class="px-6 py-3 min-w-52">Tanggal Pemesanan</th>
                        <th scope="col" class="px-6 py-3 min-w-56">Tanggal Jatuh Tempo</th>
                        <th scope="col" class="px-6 py-3 min-w-36">Vendor</th>
                        <th scope="col" class="px-6 py-3 min-w-40">Total QTY</th>
                        <th scope="col" class="px-6 py-3 min-w-40">Nilai Tagihan</th>
                        <th scope="col" class="px-6 py-3 min-w-48">Deskripsi</th>
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
</x-layout>

<script>
    /**
     * Purchase Order Management Module
     * Handles the display, pagination, and interaction with Purchase Order data in a table format
     */

    // Constants
    const PAGINATION_DISPLAY_RANGE = 2;
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 10;
    const TEXT_TRUNCATE_LENGTH = 40;

    /**
     * Data Fetching and Processing
     */
    const dataServicePurchaseOrder = {
        /**
         * Fetches product data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (page = 1, search = '') => {
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/transaction/purchase-order/list',
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
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data purchase order. Silahkan coba lagi.');
                },
            });
        },
    };

    /**
     * HTML Templates
     */
    const templates = {
        tableRow: (purchaseOrder) => `
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${purchaseOrder.code || '-'}
                </th>
                <td class="px-6 py-4">
                    ${purchaseOrder.no_factur_supplier || '-'}
                </td>
                <td class="px-6 py-4">
                    ${(purchaseOrder.order_date || '-')}
                </td>
                <td class="px-6 py-4">
                    ${(purchaseOrder.payment_due_date || '-')}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder.purchase_price ? `Rp${new Intl.NumberFormat('id-ID').format(purchaseOrder.purchase_price)}` : '0'}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder.qty_total || '0'}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder.total ? `Rp${new Intl.NumberFormat('id-ID').format(purchaseOrder.total)}` : '0'}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder.description.substring(0, TEXT_TRUNCATE_LENGTH) || '-'}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    ${templates.actionButtons(purchaseOrder.id)}
                </td>
            </tr>
        `,

        actionButtons: (id) => `
            <a href="/inventory/pharmacy/product/view/${id}" id="btn-edit-supplier">
                <button
                    id="btn-edit-product"
                    class="font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md"
                >
                    <i class="fa-solid fa-pencil"></i>
                </button>
            </a>
        `,

        loadingModal: '<div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90"><i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i></div>',
    };

    /**
     * Event Handlers
     */
    const eventHandlers = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Search input handler with debounce
            let searchTimeout;
            $('#search-name-product').on('input', function() {
                const searchValue = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    urlManager.updateParams({
                        search: searchValue,
                        page: 1
                    });
                    dataServicePurchaseOrder.fetchData(1, searchValue);
                }, DEBOUNCE_DELAY);
            });

            // Pagination click handler
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const currentSearch = $('#search-name-product').val();

                debug.log('Pagination', `Changing to page ${page}`);
                urlManager.updateParams({
                    page,
                    search: currentSearch
                });
                dataServicePurchaseOrder.fetchData(page, currentSearch);
            });

            // Browser navigation handler
            window.addEventListener('popstate', function() {
                const params = urlManager.getParams();
                $('#search-name-product').val(params.search);
                dataServicePurchaseOrder.fetchData(params.page, params.search);
            });
        },
    };

    /**
     * Initialize the purchase order table functionality
     */
    function initPurchaseOrderTable() {
        debug.log('Init', 'Initializing purchase order table...');
        const params = urlManager.getParams();
        $('#search-name-product').val(params.search);
        dataServicePurchaseOrder.fetchData(params.page, params.search);
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initPurchaseOrderTable();
        eventHandlers.init();
    });
</script>
