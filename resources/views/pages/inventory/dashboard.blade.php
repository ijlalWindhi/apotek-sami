<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div id="dashboard" class="min-h-screen bg-gray-50 p-2 sm:p-4">
        <!-- Total Sales Card -->
        <div class="mb-4 rounded-lg bg-white p-4 shadow-sm sm:p-6">
            <div class="mb-2 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-sm text-gray-600">Total Penjualan</h2>
                <div class="flex items-center gap-2">
                    <select id="penjualan_input_range"
                        class="w-full rounded-md border border-gray-200 px-3 py-1 text-sm sm:w-auto">
                        <option value="daily">Harian</option>
                        <option value="weekly">Mingguan</option>
                    </select>
                    <button id="penjualan_refresh" class="rounded-full p-1 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:gap-3">
                <h1 class="text-2xl font-semibold sm:text-3xl md:text-4xl" id="penjualan_total">Rp 0</h1>
                <span class="text-sm text-red-500"><span id="penjualan_indicator">↓</span><span
                        id="penjualan_percentage">0%</span></span>
            </div>
            <p class="text-xs mt-2">Tanggal: <span id="penjualan_range"></span></p>
            <p class="mt-2 text-xs text-gray-500">Total penjualan adalah laporan ringkasan dari transaksi dengan kondisi
                faktur penjualan lunas</p>
        </div>

        <!-- Alerts -->
        <div class="mb-4 space-y-2">
            <div id="pembelian_alert"
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between rounded-md bg-green-100 text-green-700 px-3 sm:px-4 py-3">
                <div class="flex items-center gap-2">
                    ●
                    <p class="text-xs sm:text-sm">Ada <span id="pembelian_qty">0</span> Faktur Pembelian
                        Jatuh Tempo</p>
                </div>
                <a href="/inventory/transaction/purchase-order">
                    <button class="mt-2 sm:mt-0 text-xs sm:text-sm font-medium">LIHAT</button>
                </a>
            </div>
            <div id="stock_alert"
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between rounded-md bg-green-100 text-green-700 px-3 sm:px-4 py-3">
                <div class="flex items-center gap-2">
                    ●
                    <p class="text-xs sm:text-sm">Ada <span id="stock_qty">0</span> Item Kurang Dari
                        Minimal Stock</p>
                </div>
                <a href="/inventory/pharmacy/product">
                    <button class="mt-2 sm:mt-0 text-xs sm:text-sm font-medium">LIHAT</button>
                </a>
            </div>
        </div>

        <!-- Transaction Tables -->
        <div class="grid gap-4 lg:grid-cols-2">
            <!-- Recent Transactions -->
            <div class="rounded-lg bg-white p-4 shadow-sm sm:p-6">
                <div class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-0 items-start sm:items-center justify-between">
                    <h2 class="text-sm font-medium">Ringkasan Transaksi Penjualan Terakhir</h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select class="w-full sm:w-auto rounded-md border border-gray-200 px-3 py-1 text-xs">
                            <option value="harian">Harian</option>
                            <option value="mingguan">Mingguan</option>
                        </select>
                        <button class="rounded-full p-1 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-xs uppercase">
                                    <th class="px-3 py-2 text-left">Transaksi ID</th>
                                    <th class="px-3 py-2 text-left">Tanggal</th>
                                    <th class="px-3 py-2 text-left">Pembayaran</th>
                                    <th class="px-3 py-2 text-right">Nilai Faktur</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white text-xs sm:text-sm">
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-3 py-2">SI-GPOS-02/2025/00185</td>
                                    <td class="whitespace-nowrap px-3 py-2">06/02/25</td>
                                    <td class="whitespace-nowrap px-3 py-2">CASH</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-right">75.500</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Supplier Summary -->
            <div class="rounded-lg bg-white p-4 shadow-sm sm:p-6">
                <div class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-0 items-start sm:items-center justify-between">
                    <h2 class="text-sm font-medium">Ringkasan Total Tagihan Per Supplier</h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select class="w-full sm:w-auto rounded-md border border-gray-200 px-3 py-1 text-xs">
                            <option>Harian</option>
                        </select>
                        <button class="rounded-full p-1 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-xs uppercase">
                                    <th class="px-3 py-2 text-left">Supplier</th>
                                    <th class="px-3 py-2 text-center">Faktur</th>
                                    <th class="px-3 py-2 text-right">Total Nilai Faktur</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white text-xs sm:text-sm">
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-3 py-2">PT. MUTIARA MASA MEDIKA</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-center">30</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-right">10.877.856</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    /**
     * Dashboard Module
     */
    let PENJUALAN_PERIOD = 'daily';

    /**
     * Data Fetching and Processing
     */
    const dataServiceDashboard = {
        getTotalSales: (period = 'daily') => {
            $('#dashboard').prepend(uiManager.showScreenLoader());
            PENJUALAN_PERIOD = period;

            $.ajax({
                url: '/inventory/dashboard/total-sales',
                method: 'GET',
                data: {
                    period,
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    const data = response.data;
                    // Update data on the UI
                    $('#penjualan_total').text(`Rp ${UIManager.formatCurrency(data.nominal || 0)}`);
                    $('#penjualan_indicator')
                        .text(data.status === "lost" ? '↓' : '↑')
                        .removeClass('text-green-500 text-red-500')
                        .addClass(data.status === "lost" ? 'text-red-500' : 'text-green-500');
                    $('#penjualan_percentage')
                        .text(data.percentage || 0)
                        .removeClass('text-green-500 text-red-500')
                        .addClass(data.status === "lost" ? 'text-red-500' : 'text-green-500');
                    $('#penjualan_range').text(data.range || '-');
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                },
            });
        },
        getDuePO: () => {
            $('#dashboard').prepend(uiManager.showScreenLoader());

            $.ajax({
                url: '/inventory/dashboard/due-purchase-orders',
                method: 'GET',
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    const data = response.data?.length;
                    // Update data on the UI
                    $('#pembelian_qty').text(data || 0);
                    $('#pembelian_alert').removeClass(
                            'bg-green-100 bg-red-100 text-green-700 text-red-700')
                        .addClass(data > 0 ? 'bg-red-100 text-red-700' :
                            'bg-green-100 text-green-700');
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                },
            });
        },
        getLowStock: () => {
            $('#dashboard').prepend(uiManager.showScreenLoader());

            $.ajax({
                url: '/inventory/dashboard/low-stock-items',
                method: 'GET',
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    const data = response.data?.length;
                    // Update data on the UI
                    $('#stock_qty').text(data || 0);
                    $('#stock_alert').removeClass(
                            'bg-green-100 bg-red-100 text-green-700 text-red-700')
                        .addClass(data > 0 ? 'bg-red-100 text-red-700' :
                            'bg-green-100 text-green-700');
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                },
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlersDashboard = {
        init: () => {
            // Period select handler
            $('#penjualan_input_range').on('change', function(e) {
                const period = $(this).val();
                dataServiceDashboard.getTotalSales(period);
            });

            // Refresh button handler
            $('#penjualan_refresh').on('click', function(e) {
                dataServiceDashboard.getTotalSales(PENJUALAN_PERIOD);
            });
        },
    };

    /**
     * Initialize the dashboard module
     */
    function initDashboard() {
        debug.log('Init', 'Initializing dashboard...');

        dataServiceDashboard.getTotalSales();
        dataServiceDashboard.getDuePO();
        dataServiceDashboard.getLowStock();
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initDashboard();
        eventHandlersDashboard.init();
    });
</script>
