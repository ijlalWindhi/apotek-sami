<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div id="dashboard" class="min-h-screen bg-gray-50 p-2">
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
            <p class="text-xs mt-2">Tanggal: <span id="penjualan_range">-</span></p>
            <p class="mt-2 text-xs text-gray-500">Total penjualan adalah laporan ringkasan dari transaksi dengan kondisi
                faktur penjualan lunas</p>
        </div>

        <!-- Alerts -->
        <div class="mb-4 space-y-2">
            <div id="pembelian_alert"
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between rounded-md bg-green-100 text-green-700 px-3 sm:px-4 py-3">
                <div class="flex items-center gap-2">
                    ● <div>
                        <p class="text-xs sm:text-sm">Ada <span id="pembelian_qty">0</span> Faktur Pembelian Jatuh Tempo
                        </p>
                        <p class="text-xs">Dalam waktu 7 Hari Dari Sekarang</p>
                    </div>
                </div>
                <a href="/inventory/transaction/purchase-order">
                    <button class="mt-2 sm:mt-0 text-xs sm:text-sm font-medium">LIHAT</button>
                </a>
            </div>
            <div id="stock_alert"
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between rounded-md bg-green-100 text-green-700 px-3 sm:px-4 py-3">
                <div class="flex items-center gap-2">
                    ●
                    <div>
                        <p class="text-xs sm:text-sm">Ada <span id="stock_qty">0</span> Item Kurang Dari
                            Minimal Stock</p>
                        <p class="text-xs">Kurang dari Minimum Stok</p>
                    </div>
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
                    <h2 class="text-sm font-medium">Ringkasan Transaksi Penjualan Hari Ini</h2>
                    <div id="po_refresh" class="flex items-center gap-2 w-full sm:w-auto">
                        <button class="rounded-full p-1 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg max-h-44">
                    <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="uppercase">
                                <th scope="col" class="p-1.5">Nomor Invoice</th>
                                <th scope="col" class="p-1.5">Pelanggan</th>
                                <th scope="col" class="p-1.5">Pembayaran</th>
                                <th scope="col" class="p-1.5">Status</th>
                                <th scope="col" class="p-1.5 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody id="po_table_body" class="divide-y divide-gray-200 bg-white">
                            {{-- Table content will be inserted here --}}
                            <tr>
                                <td id="po_label_empty_data" colspan="4"
                                    class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Supplier Summary -->
            <div class="rounded-lg bg-white p-4 shadow-sm sm:p-6">
                <div class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-0 items-start sm:items-center justify-between">
                    <h2 class="text-sm font-medium">Ringkasan Total Tagihan Per Supplier</h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button id="supplier_refresh" class="rounded-full p-1 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg max-h-44">
                    <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="uppercase">
                                <th scope="col" class="p-1.5">Supplier</th>
                                <th scope="col" class="p-1.5">Total Faktur</th>
                                <th scope="col" class="p-1.5 text-right">Total Nilai Faktur</th>
                            </tr>
                        </thead>
                        <tbody id="supplier_table_body" class="divide-y divide-gray-200 bg-white">
                            {{-- Table content will be inserted here --}}
                            <tr>
                                <td id="supplier_label_empty_data" colspan="4"
                                    class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Product Tables -->
        <div class="rounded-lg bg-white p-4 shadow-sm sm:p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-0 items-start sm:items-center justify-between">
                <div>
                    <h2 class="text-sm font-medium">Ringkasan Penjualan Item</h2>
                    <p class="text-xs mt-2">Tanggal: <span id="product_range">-</span></p>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <select id="product_input_range"
                            class="w-full rounded-md border border-gray-200 px-3 py-1 text-sm sm:w-auto">
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                        <button id="product_refresh" class="rounded-full p-1 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto sm:rounded-lg max-h-56">
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="uppercase">
                            <th scope="col" class="p-1.5">SKU</th>
                            <th scope="col" class="p-1.5">Item</th>
                            <th scope="col" class="p-1.5 text-right">Total Item Terjual (Satuan Terkecil)</th>
                        </tr>
                    </thead>
                    <tbody id="product_table_body" class="divide-y divide-gray-200 bg-white">
                        {{-- Table content will be inserted here --}}
                        <tr>
                            <td id="product_label_empty_data" colspan="4"
                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

<script>
    /**
     * Dashboard Module
     */
    let PENJUALAN_PERIOD = 'daily';
    let PRODUCT_PERIOD = 'daily';

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
        getPO: () => {
            $('#dashboard').prepend(uiManager.showScreenLoader());

            const date = new Date();
            const formattedDate =
                `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;
            $.ajax({
                url: '/inventory/transaction/sales-transaction/list',
                method: 'GET',
                data: {
                    start_date: formattedDate,
                    end_date: formattedDate,
                    status: "",
                    page: 1,
                    per_page: 99999
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    templatesDashboard.updateTableListItem(response.data, 'po_table_body',
                        'po_label_empty_data', templatesDashboard.tableRowPo);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                },
            });
        },
        getSupplierSummary: () => {
            $('#dashboard').prepend(uiManager.showScreenLoader());

            const date = new Date();
            const formattedDate =
                `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;
            $.ajax({
                url: '/inventory/dashboard/supplier-billing-summary',
                method: 'GET',
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    templatesDashboard.updateTableListItem(response.data, 'supplier_table_body',
                        'supplier_label_empty_data', templatesDashboard.tableRowSupplier);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                },
            });
        },
        getProduct: (period = 'daily') => {
            $('#dashboard').prepend(uiManager.showScreenLoader());
            PRODUCT_PERIOD = period;

            $.ajax({
                url: '/inventory/dashboard/product-summary',
                method: 'GET',
                data: {
                    period,
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    templatesDashboard.updateTableListItem(response.data?.products,
                        'product_table_body',
                        'product_label_empty_data', templatesDashboard.tableRowProduct);
                    $('#product_range').text(response?.data?.range || '-');
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

            // Refresh button handler for total sales
            $('#penjualan_refresh').on('click', function(e) {
                dataServiceDashboard.getTotalSales(PENJUALAN_PERIOD);
            });

            // Refresh button handler for PO
            $('#po_refresh').on('click', function(e) {
                dataServiceDashboard.getPO();
            });

            // Refresh button handler for supplier summary
            $('#supplier_refresh').on('click', function(e) {
                dataServiceDashboard.getSupplierSummary();
            });

            // Refresh button handler for product
            $('#product_refresh').on('click', function(e) {
                dataServiceDashboard.getProduct(PRODUCT_PERIOD);
            });

            // Period select handler for product
            $('#product_input_range').on('change', function(e) {
                const period = $(this).val();
                dataServiceDashboard.getProduct(period);
            });
        },
    };

    /**
     * HTML Templates
     */
    const templatesDashboard = {
        updateTableListItem: (datas, id_body, id_empty, tableRow) => {
            debug.log("UpdateTableListItem", "Starting table update");
            const tbody = $(`#${id_body}`);
            tbody.empty();

            if (!Array.isArray(datas) || datas.length === 0) {
                tbody.html(table.emptyTable());
                return;
            }

            document?.getElementById(id_empty)?.remove();
            tbody.append(datas.map((data) => tableRow(data)).join(""));
            debug.log("UpdateTable", "Table updated successfully");
        },

        tableRowPo: (data) => {
            return `<tr class="hover:bg-gray-50">
                <td class="whitespace-nowrap p-1.5">${data?.invoice_number}</td>
                <td class="whitespace-nowrap p-1.5">${data?.customer_type}</td>
                <td class="whitespace-nowrap p-1.5">${data?.payment_type?.name}</td>
                <td class="whitespace-nowrap p-1.5">
                    <span class="px-1 rounded-full text-xs font-medium ${
                        data?.status === 'Terbayar' ? 'bg-green-100 text-green-700' :
                        data?.status === 'Tertunda' ? 'bg-yellow-100 text-yellow-700' :
                        'bg-red-100 text-red-700'
                    }">${data?.status}</span>
                </td>
                <td class="whitespace-nowrap p-1 text-right">Rp${UIManager.formatCurrency(data?.total_amount)}</td>
            </tr>`;
        },

        tableRowSupplier: (data) => {
            return `<tr class="hover:bg-gray-50">
                <td class="whitespace-nowrap p-1.5">${data?.supplier_name}</td>
                <td class="whitespace-nowrap p-1.5">${data?.total_invoices}</td>
                <td class="whitespace-nowrap p-1 text-right">Rp${UIManager.formatCurrency(data?.total_billing)}</td>
            </tr>`;
        },

        tableRowProduct: (data) => {
            return `<tr class="hover:bg-gray-50">
                <td class="whitespace-nowrap p-1.5">${data?.sku || "-"}</td>
                <td class="whitespace-nowrap p-1.5">
                    <div class="space-y-1">
                        <p>${data?.name || "-"}</p>
                        <p class="text-gray-500">${data?.drug_group || "-"}</p>
                    </div>
                </td>
                <td class="whitespace-nowrap p-1.5 text-right">${data?.total_qty_sold || "-"} <span>${data?.smallest_unit || "-"}</span></td>
            </tr>`;
        },
    }

    /**
     * Initialize the dashboard module
     */
    function initDashboard() {
        debug.log('Init', 'Initializing dashboard...');

        dataServiceDashboard.getTotalSales();
        dataServiceDashboard.getDuePO();
        dataServiceDashboard.getLowStock();
        dataServiceDashboard.getPO();
        dataServiceDashboard.getSupplierSummary();
        dataServiceDashboard.getProduct();
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initDashboard();
        eventHandlersDashboard.init();
    });
</script>
