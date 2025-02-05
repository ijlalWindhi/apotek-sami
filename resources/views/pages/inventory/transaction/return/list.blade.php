<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search --}}
        <form class="flex flex-col md:flex-row sm:justify-between sm:items-center gap-4" method="POST">
            @csrf
            <div class="w-full">
                <input type="search" id="search-return" name="search-return"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nomor return" />
            </div>
            <div class="w-full">
                <div id="date-range-picker" date-rangepicker datepicker-format="dd-mm-yyyy" class="flex items-center">
                    <input id="start-date" name="start-date" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Pilih tanggal mulai">
                    <span class="mx-1 text-sm text-gray-500">ke</span>
                    <input id="end-date" name="end-date" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Pilih tanggal selesai">
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nomor Return</th>
                        <th scope="col" class="px-6 py-3">Nomor Invoice</th>
                        <th scope="col" class="px-6 py-3">Tanggal Retur</th>
                        <th scope="col" class="px-6 py-3">Jumlah</th>
                        <th scope="col" class="px-6 py-3">Total</th>
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
     * Return Management Module
     * Handles the display, pagination, and interaction with Return data in a table format
     */

    // Constants
    const PAGINATION_DISPLAY_RANGE = 2;
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 10;
    const TEXT_TRUNCATE_LENGTH = 40;

    /**
     * Data Fetching and Processing
     */
    const dataServiceReturn = {
        fetchData: (page = 1, search = '', start_date = '', end_date = '') => {
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/transaction/return/list',
                method: 'GET',
                data: {
                    search,
                    start_date,
                    end_date,
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
                    uiManager.showError(
                        'Gagal mengambil data return. Silahkan coba lagi.');
                },
            });
        },
    };

    /**
     * HTML Templates
     */
    const templates = {
        tableRow: (transaction) => `<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${transaction?.return_number || '-'}
                </th>
                <td class="px-6 py-4">
                    ${transaction?.transaction?.invoice_number || '-'}
                </td>
                <td class="px-6 py-4">
                    ${transaction?.created_at ? formatDatePrint(new Date(transaction?.created_at)) : '-'}
                </td>
                <td class="px-6 py-4">
                    ${transaction?.qty_total || 0}
                </td>
                <td class="px-6 py-4">
                    Rp${UIManager.formatCurrency(transaction?.total_return || 0)}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    <a href="/inventory/transaction/return/view/${transaction?.id}">
                        <x-button type="button">
                            <i class="fa-solid fa-info"></i>
                        </x-button>
                    </a>
                </td>
            </tr>`,
    };

    /**
     * Event Handlers
     */
    const eventHandlersReturn = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Common function to handle all filter changes
            const handleFilterChange = () => {
                const search = $('#search-return').val();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();

                urlManager.updateParams({
                    page: 1,
                    search,
                    start_date: startDate,
                    end_date: endDate,
                });

                dataServiceReturn.fetchData(1, search, startDate, endDate);
            };

            // Search input handler
            let searchTimeout;
            $('#search-return').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    handleFilterChange();
                }, DEBOUNCE_DELAY);
            });

            // Start Date input handler
            $('#start-date').on('changeDate', function(e) {
                debug.log('Date', 'Date changed...');
                handleFilterChange();
            });

            // End Date input handler
            $('#end-date').on('changeDate', function(e) {
                debug.log('Date', 'Date changed...');
                handleFilterChange();
            });

            // Pagination click handler
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const search = $('#search-return').val();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();

                debug.log('Pagination', `Changing to page ${page}`);
                urlManager.updateParams({
                    page,
                    search,
                    start_date: startDate,
                    end_date: endDate,
                });

                dataServiceReturn.fetchData(page, search, startDate, endDate);
            });
        },
    };

    /**
     * Initialize the return table functionality
     */
    function initReturnTable() {
        debug.log('Init', 'Initializing return table...');
        const params = urlManager.getParams();
        const form = $('form');

        // Set initial values for all filters
        form.find('input[name="search-return"]').val(params.search || '');
        form.find('input[name="start-date"]').val(params.start_date || '');
        form.find('input[name="end-date"]').val(params.end_date || '');

        // Initial data fetch with all parameters
        dataServiceReturn.fetchData(
            params.page || 1,
            params.search || '',
            params.start_date || '',
            params.end_date || '',
        );
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initReturnTable();
        eventHandlersReturn.init();

        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
