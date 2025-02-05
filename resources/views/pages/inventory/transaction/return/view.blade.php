<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="view-return" class="flex flex-col gap-4 md:gap-10 justify-between w-full h-full p-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start justify-between gap-4">
            <div>
                <label for="return_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor
                    Retur
                    <span class="text-red-500">*</span></label>
                <input type="text" name="return_number" id="return_number" disabled
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Terisi otomatis">
            </div>
            <div>
                <label for="invoice_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor
                    Invoice
                    <span class="text-red-500">*</span></label>
                <input type="text" name="invoice_number" id="invoice_number" disabled
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Terisi otomatis">
            </div>
            <div>
                <label for="customer_type"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pelanggan
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="customer_type" name="customer_type">
                    <option value="Umum" selected>Umum</option>
                    <option value="Rutin">Rutin</option>
                    <option value="Karyawan">Karyawan</option>
                </select>
            </div>
            <div>
                <label for="recipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resep</label>
                <input id="recipe" name="recipe" type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Resep" disabled>
            </div>
            <div>
                <label for="created_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Retur
                </label>
                <input id="created_at" name="created_at" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy"
                    type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Retur" disabled>
            </div>
            <div>
                <label for="created_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibuat
                    Oleh</label>
                <input id="created_by" name="created_by" type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Dibuat Oleh" disabled>
            </div>
            <div>
                <label for="return_reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan
                    Retur</label>
                <input id="return_reason" name="return_reason" type="text"
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                    placeholder="Alasan retur" readonly>
            </div>
        </div>

        {{-- List Item --}}
        <div class="flex flex-col gap-3">
            <h2 class="w-full bg-gray-100 p-4 rounded-md text-center font-semibold">Daftar Item</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-1 min-w-48">Nama</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Jumlah</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Satuan</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Harga</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Tuslah</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Diskon<br />(Rp / %)</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Sub Total</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Jumlah Ret.</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Satuan Ret.</th>
                            <th scope="col" class="px-3 py-1 min-w-24">Sub Total Ret.</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-product-pos">
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Price Information --}}
        <div class="flex flex-col gap-4 self-end w-1/4">
            <div>
                <label for="qty_total_return" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Produk Return</label>
                <input type="text" name="qty_total_return" id="qty_total_return" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" disabled>
            </div>
            <div>
                <label for="total_before_discount"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Sebelum
                    Diskon</label>
                <input type="text" name="total_before_discount" id="total_before_discount" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Sebelum Diskon" disabled>
            </div>
            <div>
                <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total</label>
                <input type="text" name="total" id="total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total" readonly>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('return.list') }}" class="w-full md:w-32">
                <x-button color="blue" class="w-full md:w-32">Kembali</x-button>
            </a>
        </div>
    </form>
</x-layout>

<script>
    /**
     * Detail Return Module
     * Handles the detail Return page
     */
    const url = window.location.pathname;
    const transactionId = url.split('/').pop();
    let resData = {};

    /**
     * Data Fetching and Processing
     */
    const dataServiceReturn = {
        fetchData: async () => {
            $("#view-return").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/return/${transactionId}`,
                    method: 'GET',
                    contentType: 'application/json',
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                if (!response?.success) {
                    throw new Error('Invalid response format');
                }

                resData = response.data;
                const data = response.data;
                const form = $('form');

                // Set form values and handle products
                dataServiceReturn.setFormValues(form, data);
                dataServiceReturn.setProducts(data.product_returns);
            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal mengambil data Return. Silahkan coba lagi.');
            } finally {
                $('#view-return .fixed').remove();
            }
        },

        setFormValues: (form, data) => {
            // Separate regular form fields and display-only fields
            const formFields = {
                'return_number': data?.return_number || '-',
                'invoice_number': data?.transaction?.invoice_number || '-',
                'customer_type': data?.transaction?.customer_type || '-',
                'recipe': data?.transaction?.recipe?.name || '-',
                'created_at': data?.created_at || '-',
                'created_by': data?.created_by?.name || '-',
                'return_reason': data?.return_reason,
                'qty_total_return': data?.qty_total || 0,
                'total_before_discount': UIManager.formatCurrency(data?.total_before_discount || 0),
                'total': UIManager.formatCurrency(data?.total_return || 0),
            };

            // Set values for form fields
            Object.entries(formFields).forEach(([field, value]) => {
                const element = form.find(`[name="${field}"]`);
                element.val(value);

                // Trigger change event for select elements
                if (element.is('select')) {
                    element.trigger('change');
                }
            });

            // Disable all form fields
            form.find('input, select').attr('disabled', true);

            // un-disable field reason
            form.find('input[name="reason"]').attr('disabled', false);
        },

        setProducts: (products) => {
            if (!products || products.length === 0) {
                $('#table-body-product-pos').html(`
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada produk yang dipilih
                    </td>
                </tr>`);
                return;
            }

            // Clear table body
            $('#table-body-product-pos').empty();

            // Add products to table
            let qtyTotal = 0;
            products.forEach(product => {
                qtyTotal += product.qty;
                const row = returnUtils.generateReadOnlyProductRow(product);
                $('#table-body-product-pos').append(row);
            });

            // Set total products
            $('input[name="qty_total"]').val(qtyTotal);
        },
    };

    /**
     * Initialize the detail Return page
     */
    function initTransactionDetail() {
        debug.log('Init', 'Initializing Return detail...');

        dataServiceReturn.fetchData();
    }

    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');
        initTransactionDetail();
        priceCalculationsReturn.init();

        // Initialize select2
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
