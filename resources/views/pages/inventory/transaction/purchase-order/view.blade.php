<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="view-purchase-order" class="flex flex-col gap-4 md:gap-10 justify-between w-full h-full">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start justify-between gap-4">
            <div>
                <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode
                    <span class="text-red-500">*</span></label>
                <input type="text" name="code" id="code" disabled
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Terisi otomatis">
            </div>
            <div>
                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" disabled id="supplier_id" name="supplier_id">
                    <option value="" selected disabled hidden>Pilih Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="order_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Pemesanan
                    <span class="text-red-500">*</span></label>
                <input id="order_date" name="order_date" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy"
                    type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Pemesanan" required disabled>
            </div>
            <div>
                <label for="delivery_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Pengantaran
                </label>
                <input id="delivery_date" name="delivery_date" datepicker datepicker-autohide
                    datepicker-format="dd-mm-yyyy" type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Pengantaran" required disabled>
            </div>
            <div>
                <label for="payment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                    Pembayaran
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="payment_type_id" name="payment_type_id" disabled>
                    <option value="" selected disabled hidden>Pilih Tipe Pembayaran</option>
                    @foreach ($paymentTypes as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="payment_term" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Term
                    Pembayaran
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="payment_term" name="payment_term" disabled>
                    <option value="" selected disabled hidden>Pilih Term Pembayaran</option>
                    <option value="Tunai">Tunai</option>
                    <option value="1 Hari">1 Hari</option>
                    <option value="7 Hari">7 Hari</option>
                    <option value="14 Hari">14 Hari</option>
                    <option value="21 Hari">21 Hari</option>
                    <option value="30 Hari">30 Hari</option>
                    <option value="45 Hari">45 Hari</option>
                </select>
            </div>
            <div>
                <label for="payment_due_date"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Jatuh Tempo
                </label>
                <input id="payment_due_date" name="payment_due_date" datepicker datepicker-autohide
                    datepicker-format="dd-mm-yyyy" type="text"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Jatuh Tempo" required disabled disabled>
            </div>
            <div>
                <label for="no_factur_supplier"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Faktur Supplier</label>
                <input type="text" name="no_factur_supplier" id="no_factur_supplier"
                    class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Nomor Faktur Supplier" disabled>
            </div>
            <div>
                <label for="payment_include_tax"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                    Termasuk Pajak
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="payment_include_tax" name="payment_include_tax" disabled
                    value="0">
                    <option value="" selected disabled hidden>Pilih Opsi</option>
                    <option value="1">Ya</option>
                    <option value="0" selected>Tidak</option>
                </select>
            </div>
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <label for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                <textarea id="description" name="description" rows="1"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-200 cursor-not-allowed rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Catatan" disabled></textarea>
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
                            <th scope="col" class="px-3 py-1 min-w-40">Deskripsi</th>
                            <th scope="col" class="px-3 py-1 min-w-32">Jumlah</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Satuan</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Harga</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Diskon<br />(Rp / %)</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Price Information --}}
        <div class="flex flex-col gap-4 self-end">
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
                    <input type="text" name="discount" id="discount" required disabled
                        class="bg-gray-200 border border-gray-300 cursor-not-allowed text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </div>
                <div>
                    <input type="text" name="nominal_discount" id="nominal_discount" required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                        disabled>
                </div>
            </div>
            <div>
                <label for="total_before_tax_discount"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Sebelum Pajak &
                    Diskon</label>
                <input type="text" name="total_before_tax_discount" id="total_before_tax_discount" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" disabled>
            </div>
            <div>
                <label for="discount_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Diskon</label>
                <input type="text" name="discount_total" id="discount_total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" disabled>
            </div>
            <div>
                <label for="tax_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Pajak</label>
                <input type="text" name="tax_total" id="tax_total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" disabled>
            </div>
            <div>
                <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Tagihan</label>
                <input type="text" name="total" id="total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" disabled>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('purchaseOrder.index') }}" class="w-full md:w-32">
                <x-button color="blue" class="w-full md:w-32">Kembali</x-button>
            </a>
            <div id="placeholder-payment"></div>
        </div>
    </form>
</x-layout>

<script>
    /**
     * Detail Purchase Order Module
     * Handles the detail purchase order page
     */
    const url = window.location.pathname;
    const purchaseOrderId = url.split('/').pop();

    /**
     * Data Fetching and Processing
     */
    const dataServicePurchaseOrder = {
        fetchData: async () => {
            $("#view-purchase-order").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/purchase-order/${purchaseOrderId}`,
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

                const data = response.data;
                const form = $('form');

                // Set form values for basic fields
                dataServicePurchaseOrder.setFormValues(form, data);

                // Handle products
                dataServicePurchaseOrder.setProducts(data.products);

                if (data.payment_status === "Belum Terbayar") {
                    const paymentButton =
                        `<x-button color="green" class="w-full md:w-32" id="btn-payment">Bayar</x-button>`;
                    $('#placeholder-payment').html(paymentButton);
                }

            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal mengambil data purchase order. Silahkan coba lagi.');
            } finally {
                $('#view-purchase-order .fixed').remove();
            }
        },

        updateStatusPayment: async () => {
            $("#view-purchase-order").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/transaction/purchase-order/${purchaseOrderId}/payment`,
                    method: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
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

                $('#btn-payment').remove();
            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal melakukan pembayaran. Silahkan coba lagi.');
            } finally {
                $('#view-purchase-order .fixed').remove();
            }
        },

        setFormValues: (form, data) => {
            const nominal_discount = priceCalculationsPO.calculateMainDiscount(data?.total_before_tax_discount)

            // Set basic form values
            form.find('input[name="code"]').val(data.code);
            form.find('select[name="supplier_id"]').val(data.supplier.id).trigger('change');
            form.find('input[name="order_date"]').val(data.order_date);
            form.find('input[name="delivery_date"]').val(data.delivery_date);
            form.find('select[name="payment_type_id"]').val(data.payment_type.id).trigger('change');
            form.find('select[name="payment_term"]').val(data.payment_term).trigger('change');
            form.find('input[name="payment_due_date"]').val(data.payment_due_date);
            form.find('input[name="no_factur_supplier"]').val(data.no_factur_supplier);
            form.find('select[name="payment_include_tax"]').val(data.payment_include_tax ? 1 : 0).trigger(
                'change');
            form.find('textarea[name="description"]').val(data.description);
            form.find('input[name="qty_total"]').val(data.qty_total);
            form.find('input[name="discount"]').val(data.discount);
            form.find('input[name="nominal_discount"]').val(UIManager.formatCurrency(data.nominal_discount));
            form.find('input[name="total_before_tax_discount"]').val(UIManager.formatCurrency(data
                .total_before_tax_discount));
            form.find('input[name="discount_total"]').val(UIManager.formatCurrency(data.discount_total));
            form.find('input[name="tax_total"]').val(UIManager.formatCurrency(data.tax_total));
            form.find('input[name="total"]').val(UIManager.formatCurrency(data.total));
        },

        setProducts: (products) => {
            if (!products || products.length === 0) {
                $('#table-body').html(`
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada produk yang dipilih
                    </td>
                </tr>`);
                return;
            }

            // Clear existing table content
            $('#table-body').empty();

            // Add products to table
            products.forEach(product => {
                const discount = product.discount_type === 'Percentage' ?
                    product.discount + '%' :
                    UIManager.formatCurrency(product.discount);

                const row = `
                <tr id="list_product_${product.id}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-3 py-2">
                        ${product?.product?.name || '-'}
                    </td>
                    <td class="px-3 py-2" id="product_description_${product.product.id}">
                        ${product?.product?.description || '-'}
                    </td>
                    <td class="px-3 py-2">
                        ${product.qty || 0}
                    </td>
                    <td class="px-3 py-2">
                        ${product?.unit?.symbol || "-"}
                    </td>
                    <td class="px-3 py-2">
                        ${UIManager.formatCurrency(product?.price)}
                    </td>
                    <td class="px-3 py-2">
                        ${discount}
                    </td>
                    <td class="px-3 py-2">
                        ${UIManager.formatCurrency(product.subtotal)}
                    </td>
                </tr>`;
                $('#table-body').append(row);
            });
        }
    };

    /**
     * Event Handlers
     */
    const eventHandlersPurchaseOrder = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            $('body').on('click', '#btn-payment', function() {
                dataServicePurchaseOrder.updateStatusPayment();
            });
        },
    };

    /**
     * Initialize the detail purchase order page
     */
    function initPurchaseOrderDetail() {
        debug.log('Init', 'Initializing purchase order detail...');

        dataServicePurchaseOrder.fetchData();
    }

    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');
        initPurchaseOrderDetail();
        eventHandlersPurchaseOrder.init();

        // Initialize select2
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
