<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="view-return" class="flex flex-col gap-4 md:gap-10 justify-between w-full h-full p-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start justify-between gap-4">
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
                    Transaksi
                </label>
                <input id="created_at" name="created_at" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy"
                    type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Transaksi" disabled>
            </div>
            <div>
                <label for="created_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibuat
                    Oleh</label>
                <input id="created_by" name="created_by" type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Dibuat Oleh" disabled>
            </div>
            <div>
                <label for="notes"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                <input id="notes" name="notes" type="text"
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                    placeholder="Catatan">
            </div>
            <div>
                <label for="payment_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Metode
                    Pembayaran
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="payment_type" name="payment_type">
                    <option value="" selected disabled hidden>Pilih Tipe Pembayaran</option>
                    @foreach ($paymentTypes as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status_transaction"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="status_transaction" name="status_transaction" disabled>
                    <option value="Terbayar" selected>Terbayar</option>
                    <option value="Proses">Proses</option>
                    <option value="Tertunda">Tertunda</option>
                </select>
            </div>
            <div>
                <label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan
                    Retur</label>
                <input id="reason" name="reason" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Alasan retur">
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
                <label for="qty_total_return"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
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
                <label for="total"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total</label>
                <input type="text" name="total" id="total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total" readonly>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('pos.index') }}" class="w-full md:w-32">
                <x-button color="blue" class="w-full md:w-32">Kembali</x-button>
            </a>
            <x-button color="green" class="w-full md:w-32" id="btn-submit" type="submit">Simpan</x-button>
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

    function formattedData(formData) {
        // Convert formData array to object for easier handling
        const formObject = {};
        formData.forEach(item => {
            formObject[item.name] = item.value;
        });

        // Get all product rows
        const productRows = $('#table-body-product-pos tr');
        const products = [];

        // Process each product row
        productRows.each((index, row) => {
            const productId = $(row).attr('id').split('_').pop();

            // Only include products with qty_return > 0
            const qtyReturn = parseFloat($(`#product_pos_qty_return_${productId}`).val()) || 0;
            if (qtyReturn > 0) {
                products.push({
                    product_transaction_id: $(`#product_pos_sales_transaction_id_${productId}`).val(),
                    product_id: productId,
                    unit_id: $(`#product_pos_unit_${productId}`).val(),
                    qty_return: qtyReturn,
                    subtotal_return: extractNumericValue($(`#product_pos_subtotal_return_${productId}`)
                        .val())
                });
            }
        });

        // Helper function to extract numeric value from formatted currency
        function extractNumericValue(value) {
            if (typeof value === 'number') return value;
            return parseFloat(value?.replace(/[^\d]/g, '')) || 0;
        }

        // Construct the final formatted data object
        const formatted = {
            transaction_id: transactionId, // From global variable
            return_reason: formObject.reason || null,
            qty_total: parseFloat($('#qty_total_return').val()) || 0,
            total_before_discount: extractNumericValue($('#total_before_discount').val()),
            total_return: extractNumericValue($('#total').val()),
            created_by: '{{ auth()->user()->id }}',
            products: products
        };

        return formatted;
    }

    /**
     * Data Fetching and Processing
     */
    const dataServiceReturn = {
        fetchData: async () => {
            $("#view-return").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/sales-transaction/${transactionId}`,
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
                dataServiceReturn.setProducts(data.products);
            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal mengambil data Return. Silahkan coba lagi.');
            } finally {
                $('#view-return .fixed').remove();
            }
        },

        createReturn: (data) => {
            uiManager.showScreenLoader();

            $.ajax({
                url: '/pos/return',
                method: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }


                    Swal.fire({
                        icon: "success",
                        title: "Berhasil menambahkan data",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        // Redirect based on URL
                        if (url.includes('/pos/return/view/')) {
                            window.location.href = '/pos';
                        } else {
                            window.location.href = '/inventory/transaction/return';
                        }
                    }, 500);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal membuat retur. Silahkan coba lagi.');
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                }
            });
        },

        setFormValues: (form, data) => {
            // Separate regular form fields and display-only fields
            const formFields = {
                'invoice_number': data?.invoice_number || '-',
                'customer_type': data?.customer_type || '-',
                'recipe': data?.recipe?.name || '-',
                'created_at': data?.created_at || '-',
                'created_by': data?.created_by?.name || '-',
                'notes': data?.notes,
                'status': data?.status,
                'payment_type': data?.payment_type?.id,
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
                const row = returnUtils.generateEditableProductRow(product);
                $('#table-body-product-pos').append(row);
            });

            // Set total products
            $('input[name="qty_total"]').val(qtyTotal);
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlersTransaction = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            $('form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serializeArray();
                const data = formattedData(formData);
                dataServiceReturn.createReturn(data);
            });
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
        eventHandlersTransaction.init();
        priceCalculationsReturn.init();

        // Initialize select2
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
