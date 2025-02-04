<div id="modal-search-transaction" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between py-1 px-5 border-b rounded-t dark:border-gray-600">
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    Riwayat Transaksi
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-recipe">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="w-full flex gap-2 items-end justify-between py-3 px-4" method="POST">
                @csrf
                <div class="w-full">
                    <label for="search-transaction" class="text-xs">Nomor Invoice</label>
                    <input type="search" id="search-transaction" name="search-transaction"
                        class="block px-2.5 py-1.5 w-full z-20 text-xs text-gray-900 bg-gray-50 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Cari nomor invoice" />
                </div>
                <div class="w-full">
                    <label for="date-range-picker" class="text-xs">Tanggal</label>
                    <div id="date-range-picker" date-rangepicker datepicker-format="dd-mm-yyyy"
                        class="flex items-center">
                        <input id="start-date" name="start-date" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Pilih tanggal mulai">
                        <span class="mx-1 text-xs text-gray-500">ke</span>
                        <input id="end-date" name="end-date" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Pilih tanggal selesai">
                    </div>
                </div>
                <div class="select-small w-full">
                    <label for="status-search-transaction" class="text-xs">Status
                        <select class="js-example-basic-single" id="status-search-transaction"
                            name="status-search-transaction">
                            <option value="Semua" selected>Semua</option>
                            <option value="Terbayar">Terbayar</option>
                            <option value="Proses">Proses</option>
                            <option value="Tertunda">Tertunda</option>
                        </select>
                </div>
                <x-button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </x-button>
            </form>
            <div class="relative overflow-auto shadow-md sm:rounded-lg pb-6 max-h-[50vh]">
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-1">Nomor Invoice</th>
                            <th scope="col" class="px-3 py-1">Tanggal Transaksi</th>
                            <th scope="col" class="px-3 py-1">Status</th>
                            <th scope="col" class="px-3 py-1">Pelanggan</th>
                            <th scope="col" class="px-3 py-1">Resep</th>
                            <th scope="col" class="px-3 py-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-search-transaction">
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400"
                                id="table-body-search-transaction-empty">
                                Tidak ada transaksi ditemukan
                            </td>
                        </tr>
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    /**
     * Search Transaction Modal
     * Handles all JavaScript functionalities for the Search Transaction modal
     */
    let LIST_DATA_TRANSACTION = [];
    let SEARCH_TRANSACTION = '';
    let STATUS_SEARCH_TRANSACTION = 'Semua';
    let START_DATE = '';
    let END_DATE = '';

    /**
     * Data Fetching and Processing
     */
    const dataServiceSearchTransaction = {
        fetchData: () => {
            uiManager.showLoading("#table-body-search-transaction");

            $.ajax({
                url: '/pos/transaction/list',
                method: 'GET',
                data: {
                    search: SEARCH_TRANSACTION,
                    status: STATUS_SEARCH_TRANSACTION,
                    start_date: START_DATE,
                    end_date: END_DATE,
                    page: 1,
                    per_page: PER_PAGE
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    LIST_DATA_TRANSACTION = response.data;
                    templatesTransaction.updateTableListItem(response.data);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data transaksi. Silahkan coba lagi.',
                        '#table-body-search-transaction');
                },
            });
        },
    };

    /**
     * HTML Templates
     */
    const templatesTransaction = {
        updateTableListItem: (data) => {
            const tbody = $("#table-body-search-transaction");

            if (!Array.isArray(data) || data?.length === 0) {
                tbody.html(table.emptyTable());
                return;
            }

            tbody.empty();
            tbody.append(data.map((transaction) => templatesTransaction.tableRowTransaction(transaction)).join(
                ""));
            debug.log("UpdateTable", "Table updated successfully");
        },

        tableRowTransaction: (transaction) => `
            <tr id="list_transaction_${transaction.id}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${transaction?.invoice_number || '-'}
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    ${transaction?.created_at ? formatDatePrint(new Date(transaction.created_at)) : '-'}
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <span class="bg-${transaction?.status === "Terbayar" ? 'green' : transaction?.status === "Proses" ? 'yellow' : 'red'}-100 text-${transaction?.status === "Terbayar" ? 'green' : transaction?.status === "Proses" ? 'yellow' : 'red'}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">${transaction.status || "-"}</span>
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    ${transaction?.customer_type || '-'}
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    ${transaction?.recipe?.name || '-'}
                </td>
                <td class="px-3 py-2 flex gap-2 items-center">
                    <x-button
                        id="btn-print-transaction-${transaction.id}"
                        data-id="${transaction.id}"
                        color="yellow"
                        size="sm"
                    >
                        <i class="fa-solid fa-print"></i>
                    </x-button>
                    <x-button
                        id="btn-detail-transaction-${transaction.id}"
                        data-id="${transaction.id}"
                        color="blue"
                        size="sm"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </x-button>
                    ${transaction.status === 'Terbayar' ?
                        `<a href="/pos/return/view/${transaction.id}">
                            <x-button
                                id="btn-return-transaction-${transaction.id}"
                                data-id="${transaction.id}"
                                color="red"
                                size="sm"
                            >
                                <i class="fa-solid fa-rotate-left mr-2"></i> Return
                            </x-button>
                        </a>`
                    : ''}
                </td>
            </tr>
        `,
    };

    /**
     * Event Handlers
     */
    const eventHandlersSearchTransaction = {
        init: () => {
            // Search transaction
            $('#search-transaction').on('input', function() {
                SEARCH_TRANSACTION = $(this).val();
            });

            // Date range picker
            $('#start-date').on('changeDate', function(e) {
                START_DATE = $(this).val();
            });

            $('#end-date').on('changeDate', function(e) {
                END_DATE = $(this).val();
            });

            // Status search
            $('#status-search-transaction').on('change', function() {
                STATUS_SEARCH_TRANSACTION = $(this).val();
            });

            // Modal open handler
            $('[data-modal-target="modal-search-transaction"]').on('click', () => {
                SEARCH_TRANSACTION = '';
                STATUS_SEARCH_TRANSACTION = 'Semua';
                START_DATE = '';
                END_DATE = '';
                dataServiceSearchTransaction.fetchData();
                $('#search-transaction').val('');
            });

            // Form submit handler
            $('#modal-search-transaction form').on('submit', function(e) {
                e.preventDefault();
                dataServiceSearchTransaction.fetchData();
            });

            // Print transaction
            $(document).on('click', '[id^="btn-print-transaction-"]', function() {
                const transactionId = $(this).data('id');
                const transaction = LIST_DATA_TRANSACTION.find((item) => item.id === transactionId);

                if (!transaction) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mencetak transaksi',
                        text: 'Transaksi tidak ditemukan. Silahkan coba lagi.',
                    })
                    return;
                }

                printReceipt(transaction);
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersSearchTransaction.init();
    });
</script>
