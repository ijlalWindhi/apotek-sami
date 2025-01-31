<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="view-sales-transaction" class="flex flex-col gap-4 md:gap-10 justify-between w-full h-full">
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
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
        </div>

        {{-- List Item --}}
        <div class="flex flex-col gap-3">
            <h2 class="w-full bg-gray-100 p-4 rounded-md text-center font-semibold">Daftar Item</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-1 min-w-48">Nama</th>
                            <th scope="col" class="px-3 py-1 min-w-32">Jumlah</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Satuan</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Harga</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Tuslah</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Diskon<br />(Rp / %)</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Sub Total</th>
                            <th scope="col" class="px-3 py-1" id="head-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-product-pos">
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Price Information --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start justify-between gap-4">
            <div>
                <label for="qty_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Produk</label>
                <input type="text" name="qty_total" id="qty_total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" disabled>
            </div>
            <div class="flex gap-2 items-end justify-between">
                <div>
                    <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diskon
                        (Rp / %)</label>
                    <input type="text" name="discount" id="discount" value="0"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </div>
                <div>
                    <input type="text" name="nominal_discount" id="nominal_discount" value="0"
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                        disabled>
                </div>
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
                <label for="paid_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Dibayarkan</label>
                <input type="text" name="paid_amount" id="paid_amount" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Total Dibayarkan">
            </div>
            <div class="text-red-500">
                <label for="change_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Kembalian</label>
                <p class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    id="change_amount">0</p>
            </div>
            <div class="text-green-500">
                <label for="total_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Tagihan</label>
                <p class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    id="total_amount">0</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('salesTransaction.index') }}" class="w-full md:w-32">
                <x-button color="blue" class="w-full md:w-32">Kembali</x-button>
            </a>
            <div id="placeholder-payment"></div>
            <div id="placeholder-process"></div>
        </div>
    </form>
</x-layout>

<script>
    /**
     * Detail Sales Transaction Module
     * Handles the detail Sales Transaction page
     */
    const url = window.location.pathname;
    const salesTransactionId = url.split('/').pop();
    let resData = {};

    /**
     * Data Fetching and Processing
     */
    const dataServiceTransaction = {
        fetchData: async () => {
            $("#view-sales-transaction").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/sales-transaction/${salesTransactionId}`,
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
                const isReadOnly = data.status === "Proses" || data.status === "Terbayar";

                // Set form values and handle products
                dataServiceTransaction.setFormValues(form, data, isReadOnly);
                dataServiceTransaction.setProducts(data.products, isReadOnly);

                // Handle button display based on status
                dataServiceTransaction.setActionButtons(data.status);

            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal mengambil data Sales Transaction. Silahkan coba lagi.');
            } finally {
                $('#view-sales-transaction .fixed').remove();
            }
        },

        updateStatusProsesToTerbayar: async () => {
            $("#view-sales-transaction").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/sales-transaction/${salesTransactionId}/updateStatusProsesToTerbayar`,
                    method: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT',
                    }
                });

                if (!response?.success) {
                    throw new Error('Invalid response format');
                }

                Swal.fire({
                    icon: "success",
                    title: "Berhasil melakukan pembayaran",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    window.location.href = '/inventory/transaction/sales-transaction';
                }, 500);
            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal melakukan pembayaran. Silahkan coba lagi.');
            } finally {
                $('#view-sales-transaction .fixed').remove();
            }
        },

        updateStatus: async (data) => {
            $("#view-sales-transaction").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/sales-transaction/${salesTransactionId}/updateStatus`,
                    method: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT',
                    }

                });

                if (!response?.success) {
                    throw new Error('Invalid response format');
                }

                Swal.fire({
                    icon: "success",
                    title: `Berhasil mengubah status menjadi ${data.status}`,
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    window.location.href = '/inventory/transaction/sales-transaction';
                }, 500);
            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal melakukan pembayaran. Silahkan coba lagi.');
            } finally {
                $('#view-sales-transaction .fixed').remove();
            }
        },

        setFormValues: (form, data, isReadOnly = false) => {
            // Separate regular form fields and display-only fields
            const formFields = {
                'invoice_number': data.invoice_number,
                'customer_type': data.customer_type,
                'recipe': data.recipe.name || '-',
                'created_at': data.created_at,
                'created_by': data.created_by.name || '-',
                'notes': data.notes,
                'status': data.status,
                'payment_type': data.payment_type.id,
                'qty_total': data.qty_total,
                'discount': data.discount_type === 'Percentage' ?
                    parseInt(data.discount) + '%' : UIManager.formatCurrency(data.discount),
                'nominal_discount': UIManager.formatCurrency(data.nominal_discount),
                'total_before_discount': UIManager.formatCurrency(data.total_before_discount),
                'paid_amount': UIManager.formatCurrency(data.paid_amount),
            };

            // Display-only fields that use <p> tags
            const displayFields = {
                'change_amount': UIManager.formatCurrency(data.change_amount),
                'total_amount': UIManager.formatCurrency(data.total_amount)
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

            // Set values for display fields
            Object.entries(displayFields).forEach(([field, value]) => {
                $(`#${field}`).text(value);
            });

            // Handle readonly state if needed
            if (isReadOnly) {
                // Disable all form fields
                form.find('input, select').attr('disabled', true);

                // Special handling for specific fields
                const fieldsToModify = ['notes', 'paid_amount', 'discount'];
                fieldsToModify.forEach(field => {
                    form.find(`input[name="${field}"]`)
                        .removeClass('bg-gray-50')
                        .addClass('bg-gray-200 cursor-not-allowed')
                        .prop('disabled', true);
                });
            }
        },

        setProducts: (products, isReadOnly = false) => {
            if (!products || products.length === 0) {
                $('#table-body-product-pos').html(`
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada produk yang dipilih
                    </td>
                </tr>`);
                return;
            }

            // Clear existing table content and action header if readonly
            if (isReadOnly) {
                $('#head-action').empty();
            }

            // Clear table body
            $('#table-body-product-pos').empty();

            // Add products to table
            let qtyTotal = 0;
            products.forEach(product => {
                qtyTotal += product.qty;
                const row = isReadOnly ?
                    salesTransactionUtils.generateReadOnlyProductRow(product) :
                    salesTransactionUtils.generateEditableProductRow(product);
                $('#table-body-product-pos').append(row);
            });

            // Set total products
            $('input[name="qty_total"]').val(qtyTotal);
        },

        setActionButtons: (status) => {
            const buttons = {
                "Bayar": `<x-button color="green" class="w-full md:w-32" id="btn-payment">Bayar</x-button>`,
                "Proses": `<x-button color="yellow" class="w-full md:w-32" id="btn-process">Proses</x-button>`
            };

            if (status === "Tertunda") {
                $('#placeholder-payment').html(buttons["Bayar"]);
                $('#placeholder-process').html(buttons["Proses"]);
            } else if (status === "Proses") {
                $('#placeholder-payment').html(buttons["Bayar"]);
            }
        }
    };

    /**
     * Event Handlers
     */
    const eventHandlersTransaction = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            $('body').on('click', '#btn-payment', function() {
                if (resData?.status === "Proses") {
                    dataServiceTransaction.updateStatusProsesToTerbayar();
                } else if (resData?.status === "Tertunda") {
                    event.preventDefault();
                    const data = formattedDataSalesTransaction({
                        created_by: resData.created_by.id,
                    });
                    const payload = {
                        ...data,
                        status: "Terbayar"
                    };
                    dataServiceTransaction.updateStatus(payload);
                }
            });

            $('body').on('click', '#btn-process', function() {
                event.preventDefault();
                const data = formattedDataSalesTransaction({
                    created_by: resData.created_by.id,
                });
                const payload = {
                    ...data,
                    status: "Proses"
                };
                dataServiceTransaction.updateStatus(payload);
            });
        },
    };

    /**
     * Initialize the detail Sales Transaction page
     */
    function initTransactionDetail() {
        debug.log('Init', 'Initializing Sales Transaction detail...');

        dataServiceTransaction.fetchData();
    }

    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');
        initTransactionDetail();
        eventHandlersTransaction.init();
        priceCalculationsPOS.init();

        // Initialize select2
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
