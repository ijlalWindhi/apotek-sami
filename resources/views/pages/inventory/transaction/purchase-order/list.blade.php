<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search & Add Button --}}
        <div class="flex flex-col md:flex-row sm:justify-between sm:items-center gap-4">
            <div class="w-full">
                <input type="search" id="faktur" name="faktur"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari no faktur, faktur supplier, supplier" />
            </div>
            <div class="w-full">
                <input id="date" name="date" datepicker datepicker-buttons datepicker-autohide
                    datepicker-format="dd-mm-yyyy" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal pemesanan/jatuh tempo" required>
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
                        <th scope="col" class="px-6 py-3 min-w-52">Status Pembayaran</th>
                        <th scope="col" class="px-6 py-3 min-w-44">Supplier</th>
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
         * @param {string} faktur - Search term
         * @param {string} date - Date
         */
        fetchData: (page = 1, faktur = '', date = '') => {
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/transaction/purchase-order/list',
                method: 'GET',
                data: {
                    faktur,
                    date,
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
                    ${purchaseOrder?.code || '-'}
                </th>
                <td class="px-6 py-4">
                    ${purchaseOrder?.no_factur_supplier || '-'}
                </td>
                <td class="px-6 py-4">
                    ${(purchaseOrder?.order_date || '-')}
                </td>
                <td class="px-6 py-4">
                    ${(purchaseOrder?.payment_due_date || '-')}
                </td>
                <td class="px-6 py-4">
                    ${(purchaseOrder?.payment_status === 'Lunas' ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Lunas</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Belum Terbayar</span>')}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder?.supplier?.name || '-'}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder?.qty_total || '0'}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder?.total ? `Rp${new Intl.NumberFormat('id-ID').format(purchaseOrder.total)}` : '0'}
                </td>
                <td class="px-6 py-4">
                    ${purchaseOrder?.description?.substring(0, TEXT_TRUNCATE_LENGTH) || '-'}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    ${templates.actionButtons(purchaseOrder.id)}
                </td>
            </tr>
        `,

        actionButtons: (id) => `
            <a href="/inventory/transaction/purchase-order/view/${id}">
                <button
                    class="font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md"
                >
                    <i class="fa-solid fa-info"></i>
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
            // Common function to handle all filter changes
            const handleFilterChange = () => {
                const searchValue = $('#faktur').val();
                const dateValue = $('#date').val();

                urlManager.updateParams({
                    search: searchValue,
                    date: dateValue,
                    page: 1
                });

                dataServicePurchaseOrder.fetchData(1, searchValue, dateValue);
            };

            // Faktur input handler with debounce
            let searchTimeout;
            $('#faktur').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    handleFilterChange();
                }, DEBOUNCE_DELAY);
            });

            // Date input handler
            $('#date').on('changeDate', function() {
                debug.log('Date', 'Date changed...');
                handleFilterChange();
            });

            // Pagination click handler
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const searchValue = $('#faktur').val();
                const dateValue = $('#date').val();

                debug.log('Pagination', `Changing to page ${page}`);
                urlManager.updateParams({
                    page,
                    search: searchValue,
                    date: dateValue
                });

                dataServicePurchaseOrder.fetchData(page, searchValue, dateValue);
            });

            // Browser navigation handler
            window.addEventListener('popstate', function() {
                const params = urlManager.getParams();
                $('#faktur').val(params.search || '');
                $('#date').val(params.date || '');
                dataServicePurchaseOrder.fetchData(
                    params.page || 1,
                    params.search || '',
                    params.date || ''
                );
            });
        },
    };

    /**
     * Initialize the purchase order table functionality
     */
    function initPurchaseOrderTable() {
        debug.log('Init', 'Initializing purchase order table...');
        const params = urlManager.getParams();

        // Set initial values for all filters
        $('#faktur').val(params.search || '');
        const dateInput = $('#date');
        if (dateInput) {
            dateInput.val(params.date || '');
        }

        // Initial data fetch with all parameters
        dataServicePurchaseOrder.fetchData(
            params.page || 1,
            params.search || '',
            params.date || ''
        );
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initPurchaseOrderTable();
        eventHandlers.init();
    });
</script>
