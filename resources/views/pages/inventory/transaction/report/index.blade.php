<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-2" id="report-transaction">
        <form class="flex flex-col md:flex-row sm:justify-between items-end gap-4" method="POST">
            @csrf
            <div class="w-full">
                <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai
                    <span class="text-red-500">*</span></label>
                <input id="start_date" name="start_date" type="text" datepicker datepicker-autohide
                    datepicker-format="dd-mm-yyyy"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pilih tanggal mulai" value="">
            </div>
            <div class="w-full">
                <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Selesai
                    <span class="text-red-500">*</span></label>
                <input id="end_date" name="end_date" type="text" datepicker datepicker-autohide
                    datepicker-format="dd-mm-yyyy"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pilih tanggal selesai" value="">
            </div>
            <div class="w-full">
                <label for="product_id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Produk</label>
                <select class="js-example-basic-single" id="product_id" name="product_id">
                    <option value="Semua" selected>Semua</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-1">
                <x-button class="w-full md:w-auto" id="btn-search"><i
                        class="fa-solid mr-1 fa-magnifying-glass"></i>Cari</x-button>
                <x-button class="w-full md:w-auto" color="green" id="btn-export"><i
                        class="fa-solid mr-1 fa-table"></i>Export</x-button>
            </div>
        </form>

        <div class="border rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b">
                        <th colspan="2" class="text-center py-2 text-sm font-semibold">Hasil Pencarian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-2 px-4">Penjualan</td>
                        <td class="py-2 px-4 text-right" id="penjualan">Rp0</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Diskon Penjualan</td>
                        <td class="py-2 px-4 text-right" id="diskon_penjualan">Rp0</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Tuslah</td>
                        <td class="py-2 px-4 text-right" id="tuslah">Rp0</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Retur Penjualan</td>
                        <td class="py-2 px-4 text-right" id="retur_penjualan">Rp0</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Penjualan Bersih</td>
                        <td class="py-2 px-4 text-right" id="penjualan_bersih">Rp0</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Harga Pokok Pembelian</td>
                        <td class="py-2 px-4 text-right" id="harga_pokok_pembelian">Rp0</td>
                    </tr>
                    <tr class="border-b bg-blue-500 text-white font-bold">
                        <td class="py-2 px-4">Keuntungan Apotek</td>
                        <td class="py-2 px-4 text-right" id="keuntungan_apotek">Rp0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

<script>
    /**
     * Data Fetching and Processing
     */
    const dataServiceReport = {
        fetchData: (start_date = '', end_date = '', product_id = '') => {
            $("#report-transaction").prepend(uiManager.showScreenLoader());

            $.ajax({
                url: '/inventory/transaction/report/list',
                method: 'GET',
                data: {
                    start_date,
                    end_date,
                    product_id,
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    const data = response.data;
                    $('#penjualan').text(`Rp${UIManager.formatCurrency(data.penjualan)}`);
                    $('#diskon_penjualan').text(
                        `Rp${UIManager.formatCurrency(data.diskon_penjualan)}`);
                    $('#tuslah').text(`Rp${UIManager.formatCurrency(data.tuslah)}`);
                    $('#retur_penjualan').text(
                        `Rp${UIManager.formatCurrency(data.retur_penjualan)}`);
                    $('#penjualan_bersih').text(
                        `Rp${UIManager.formatCurrency(data.penjualan_bersih)}`);
                    $('#harga_pokok_pembelian').text(
                        `Rp${UIManager.formatCurrency(data.harga_pokok_pembelian)}`);
                    $('#keuntungan_apotek').text(
                        `Rp${UIManager.formatCurrency(data.keuntungan_apotek)}`);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data report. Silahkan coba lagi.');
                },
                complete: () => {
                    $('#report-transaction .fixed').remove();
                },
            });
        },

        export: (start_date = '', end_date = '', product_id = '') => {
            $("#report-transaction").prepend(uiManager.showScreenLoader());

            $.ajax({
                url: '/inventory/transaction/report/export',
                method: 'GET',
                data: {
                    start_date,
                    end_date,
                    product_id,
                },
                success: (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    // Convert base64 to blob
                    const byteCharacters = atob(response.data.file);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });

                    // Create download link
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = response.data.filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal export data report. Silahkan coba lagi.');
                },
                complete: () => {
                    $('#report-transaction .fixed').remove();
                },
            });
        }
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
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();
                const product_id = $('#product_id').val() || 'Semua';

                urlManager.updateParams({
                    start_date,
                    end_date,
                    product_id,
                });

                dataServiceReport.fetchData(start_date, end_date, product_id);
            };

            // Event handler for search button
            $('#btn-search').on('click', (e) => {
                e.preventDefault();
                handleFilterChange();
            });

            // Event handler for datepicker change
            $('#btn-export').on('click', (e) => {
                e.preventDefault();
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();
                const product_id = $('#product_id').val() || 'Semua';

                dataServiceReport.export(start_date, end_date, product_id);
            });
        },
    };

    /**
     * Initialize the page
     */
    function initPage() {
        debug.log('Init', 'Initializing purchase order table...');
        const params = urlManager.getParams();
        const today = new Date();
        const formattedDate = ('0' + today.getDate()).slice(-2) + '-' + ('0' + (today.getMonth() + 1)).slice(-
            2) + '-' + today.getFullYear();

        // Set initial values for all filters
        $('#start_date').val(params.start_date || formattedDate);
        $('#end_date').val(params.end_date || formattedDate);
        $('#product_id').val(params.product_id || 'Semua').trigger('change');

        // Initial data fetch with all parameters
        dataServiceReport.fetchData(
            params.start_date || formattedDate,
            params.end_date || formattedDate,
            params.product_id || '',
        );
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlers.init();
        initPage();

        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
