<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="purchase-order" class="flex flex-col gap-4 md:gap-10 justify-between w-full h-full">
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
                <select class="js-example-basic-single" id="supplier_id" name="supplier_id">
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
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Pemesanan" required>
            </div>
            <div>
                <label for="delivery_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Pengantaran
                </label>
                <input id="delivery_date" name="delivery_date" datepicker datepicker-autohide
                    datepicker-format="dd-mm-yyyy" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Pengantaran" required>
            </div>
            <div>
                <label for="payment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                    Pembayaran
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="payment_type_id" name="payment_type_id">
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
                <select class="js-example-basic-single" id="payment_term" name="payment_term">
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
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tanggal Jatuh Tempo" required readonly>
            </div>
            <div>
                <label for="no_factur_supplier"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Faktur Supplier</label>
                <input type="text" name="no_factur_supplier" id="no_factur_supplier"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Nomor Faktur Supplier">
            </div>
            <div>
                <label for="payment_include_tax"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                    Termasuk Pajak
                    <span class="text-red-500">*</span></label>
                <select class="js-example-basic-single" id="payment_include_tax" name="payment_include_tax"
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
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Catatan"></textarea>
            </div>
        </div>

        {{-- List Item --}}
        <div class="flex flex-col gap-3">
            <h2 class="w-full bg-gray-100 p-4 rounded-md text-center font-semibold">Daftar Item</h2>
            <x-button color="blue" data-modal-target="modal-add-product" data-modal-toggle="modal-add-product"
                class="w-full">
                <i class="fa-solid fa-plus"></i>
                <span class="ms-2">Tambah</span>
            </x-button>
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
                            <th scope="col" class="px-3 py-1">Aksi</th>
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
                    placeholder="Total Produk" readonly>
            </div>
            <div class="flex gap-2 items-end justify-between">
                <div>
                    <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diskon
                        (Rp / %)</label>
                    <input type="text" name="discount" id="discount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </div>
                <div>
                    <input type="text" name="nominal_discount" id="nominal_discount" required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                        readonly>
                </div>
            </div>
            <div>
                <label for="total_before_tax_discount"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Sebelum Pajak &
                    Diskon</label>
                <input type="text" name="total_before_tax_discount" id="total_before_tax_discount" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" readonly>
            </div>
            <div>
                <label for="discount_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Diskon</label>
                <input type="text" name="discount_total" id="discount_total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" readonly>
            </div>
            <div>
                <label for="tax_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Pajak</label>
                <input type="text" name="tax_total" id="tax_total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" readonly>
            </div>
            <div>
                <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                    Tagihan</label>
                <input type="text" name="total" id="total" required
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Total Produk" readonly>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('purchaseOrder.index') }}" class="w-full md:w-32">
                <x-button color="red" class="w-full md:w-32">Batal</x-button>
            </a>
            <x-button color="blue" type="submit" class="w-full md:w-32">Simpan</x-button>
        </div>
    </form>

    {{-- Modal Add Product --}}
    <x-pages.inventory.transaction.purchase-order.modal-add-product />
</x-layout>

<script>
    /**
     * Purchase Order Create Page
     * Handles all JavaScript functionalities for the purchase order creation page
     */
    // Constants
    let taxPercentage = 0;
    let resTax = [];

    function formattedData(formData) {
        // Convert formData array to object
        const formDataObj = {};
        formData.forEach(item => {
            formDataObj[item.name] = item.value;
        });

        // Initialize products array
        const products = [];
        const productRows = $('#table-body tr').not(':has(td[colspan])');

        // Process each product row
        productRows.each(function() {
            const row = $(this);
            const productId = row.find('input[id^="product_id_"]').val();

            if (productId) {
                const qty = parseInt(row.find(`input[id^="product_total_${productId}"]`).val()) || 0;
                const price = parseInt(row.find(`input[id^="product_price_${productId}"]`).val()?.replace(
                    /[^\d]/g, '')) || 0;
                const discountInput = row.find(`input[id^="product_discount_${productId}"]`).val();
                const subtotal = parseInt(row.find(`input[id^="product_subtotal_${productId}"]`).val()?.replace(
                    /[^\d]/g, '')) || 0;

                let discount = 0;
                let discountType = 'Nominal';

                if (discountInput) {
                    if (discountInput.endsWith('%')) {
                        discount = parseFloat(discountInput || 0);
                        discountType = 'Percentage';
                    } else {
                        discount = parseInt(discountInput?.replace(/[^\d]/g, '') || 0);
                    }
                }

                products.push({
                    product: productId,
                    qty: qty,
                    price: price,
                    discount: discount,
                    discount_type: discountType,
                    subtotal: subtotal,
                    unit: row.find(`select[id^="product_unit_${productId}"]`).val(),
                });
            }
        });

        // Format dates from DD-MM-YYYY to YYYY-MM-DD
        const formatDate = (dateStr) => {
            if (!dateStr) return null;
            const [day, month, year] = dateStr.split('-');
            return `${year}-${month}-${day} 00:00:00`;
        };
        console.log(formDataObj.payment_term);

        // Build the final request object
        const requestData = {
            code: 'PO-' + new Date().toISOString().replace(/[-:.TZ]/g, '').slice(0, 14),
            supplier_id: formDataObj.supplier_id,
            order_date: formatDate(formDataObj.order_date),
            delivery_date: formatDate(formDataObj.delivery_date),
            payment_due_date: formatDate(formDataObj.payment_due_date),
            tax_id: resTax[0]?.id || 1,
            no_factur_supplier: formDataObj.no_factur_supplier,
            description: formDataObj.description,
            payment_type_id: formDataObj.payment_type_id,
            payment_term: formDataObj.payment_term,
            payment_include_tax: formDataObj.payment_include_tax === '1',
            discount: parseFloat(formDataObj.discount || 0),
            qty_total: Number(formDataObj.qty_total || 0),
            discount: formDataObj.discount?.endsWith('%') ? parseFloat(formDataObj?.discount || 0) : parseInt(
                formDataObj
                .discount?.replace(/[^\d]/g, '') || 0),
            discount_type: formDataObj.discount?.endsWith('%') ? 'Percentage' : 'Nominal',
            nominal_discount: parseFloat((formDataObj.nominal_discount || '0').replace(/[^\d]/g, '')),
            total_before_tax_discount: parseFloat((formDataObj.total_before_tax_discount || '0').replace(/[^\d]/g,
                '')),
            tax_total: parseFloat((formDataObj.tax_total || '0').replace(/[^\d]/g, '')),
            discount_total: parseFloat((formDataObj.discount_total || '0').replace(/[^\d]/g, '')),
            total: parseFloat((formDataObj.total || '0').replace(/[^\d]/g, '')),
            products: products,
        };

        return requestData;
    }

    /**
     * Data Fetching and Processing
     */
    const dataServicePurchaseOrder = {
        fetchData: () => {
            $("#purchase-order").prepend(uiManager.showScreenLoader());

            $.ajax({
                url: '/inventory/master/tax/list',
                method: 'GET',
                data: {
                    page: 1,
                    per_page: 10,
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    taxPercentage = response.data[0].rate;
                    resTax = response.data;
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data pajak. Silahkan coba lagi.');
                },
                complete: () => {
                    $('#purchase-order .fixed').remove();
                }
            });
        },

        createPurchaseOrder: (data) => {
            uiManager.showScreenLoader();

            $.ajax({
                url: '/inventory/transaction/purchase-order',
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

                    // Redirect to page list
                    setTimeout(() => {
                        window.location.href = '/inventory/transaction/purchase-order';
                    }, 300);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlerProduct = {
        init: () => {
            // Submit form
            $('form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serializeArray();
                const data = formattedData(formData);
                dataServicePurchaseOrder.createPurchaseOrder(data);
            });

            // Handle payment term changes
            $(document).on('change', '#payment_term', function() {
                const paymentTerm = $(this).val();
                const orderDate = $('#order_date').val();
                const paymentDueDate = $('#payment_due_date');

                if (!orderDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tanggal pemesanan belum diisi!',
                    });
                    // Reset select to default state
                    $(this).val('').trigger('change.select2');
                    // Clear the payment due date
                    paymentDueDate.val('');
                    return;
                }

                eventHandlerProduct.updateDueDate(orderDate, paymentTerm);
            });

            // Handle order date changes
            $('#order_date').on('changeDate', function() {
                const paymentTerm = $('#payment_term').val();
                const orderDate = $(this).val();

                if (paymentTerm) {
                    eventHandlerProduct.updateDueDate(orderDate, paymentTerm);
                }
            });

            // Handle change tax
            $('#payment_include_tax').on('change', function() {
                priceCalculationsPO.updateAllTotals();
            });

            // Handle change delivery_date
            $('#delivery_date').on('changeDate', function() {
                const orderDate = $('#order_date').val();
                const deliveryDate = $(this).val();

                if (orderDate && deliveryDate) {
                    const [orderDay, orderMonth, orderYear] = orderDate.split('-');
                    const [deliveryDay, deliveryMonth, deliveryYear] = deliveryDate.split('-');

                    if (new Date(orderYear, orderMonth - 1, orderDay) > new Date(deliveryYear,
                            deliveryMonth - 1,
                            deliveryDay)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Tanggal pengantaran tidak boleh sebelum tanggal pemesanan!',
                        });
                        $(this).val('').trigger('change.select2');
                    }
                }
            });
        },

        // Helper function to update due date
        updateDueDate: (orderDate, paymentTerm) => {
            if (!orderDate || !paymentTerm) return;

            const paymentDueDate = $('#payment_due_date');

            if (paymentTerm === 'Tunai') {
                paymentDueDate.val(orderDate);
            } else {
                const [day, month, year] = orderDate.split('-');
                const dueDate = new Date(year, month - 1, day);
                dueDate.setDate(dueDate.getDate() + parseInt(paymentTerm.split(' ')[0]));
                const formattedDate =
                    `${dueDate.getDate().toString().padStart(2, '0')}-${(dueDate.getMonth() + 1).toString().padStart(2, '0')}-${dueDate.getFullYear()}`;
                paymentDueDate.val(formattedDate);
            }
        }
    };

    const productCalculations = {
        init: () => {
            // Handle plus button clicks
            $(document).on('click', '[id^="btn-plus-product-"]', function() {
                const productId = this.id.split('btn-plus-product-')[1];
                const inputElement = $(`#product_total_${productId}`);
                inputElement.val((parseInt(inputElement.val()) || 0) + 1);
                productCalculations.calculateSubtotal(productId);
            });

            // Handle minus button clicks
            $(document).on('click', '[id^="btn-minus-product-"]', function() {
                const productId = this.id.split('btn-minus-product-')[1];
                const inputElement = $(`#product_total_${productId}`);
                const currentValue = parseInt(inputElement.val()) || 0;
                if (currentValue > 0) {
                    inputElement.val(currentValue - 1);
                    productCalculations.calculateSubtotal(productId);
                }
            });

            // Handle manual quantity input
            $(document).on('input', '[id^="product_total_"]', function() {
                const productId = this.id.split('product_total_')[1];
                productCalculations.calculateSubtotal(productId);
            });

            // Handle price changes
            $(document).on('input', '[id^="product_price_"]', function() {
                const productId = this.id.split('product_price_')[1];
                // Remove non-numeric characters and convert to number
                $(this).val($(this).val()?.replace(/[^\d]/g, ''));
                productCalculations.calculateSubtotal(productId);
            });

            // Handle discount changes
            $(document).on('input', '[id^="product_discount_"]', function() {
                const productId = this.id.split('product_discount_')[1];
                productCalculations.calculateSubtotal(productId);
            });

            // Handle delete button clicks
            $(document).on('click', '[id^="btn-delete-product-"]', function() {
                const productId = this.id.split('btn-delete-product-')[1];

                // Show confirmation dialog
                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    // Remove the entire row
                    $(`tr:has(#btn-delete-product-${productId})`).remove();

                    // Trigger custom event for total calculations
                    $(document).trigger('subtotalUpdated');

                    // Check if table is empty and show empty state if needed
                    if ($('#table-body tr').length === 0) {
                        $('#table-body').html(`
                        <tr>
                            <td id="label_empty_data" colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada produk yang dipilih
                            </td>
                        </tr>
                    `);
                    }
                }
            });

            // Handle unit changes
            $(document).on('change', '[id^="product_unit_"]', function() {
                const productId = this.id.split('product_unit_')[1];
                const unitId = $(this).val();
                const unitName = $(this).find('option:selected').text();
                const conversionValue = parseInt($(`#product_conversion_${productId}`).val()) || 1;

                // Get the selected option's parent select element
                const selectElement = $(this);
                const isLargestUnit = selectElement.find('option:first-child').val() === unitId;

                // Get current price input element
                const priceInput = $(`#product_price_${productId}`);

                // Get or store original price
                let originalPrice;
                if (!priceInput.data('original-price')) {
                    // If original price is not stored yet, store current price
                    originalPrice = parseInt(priceInput.val()?.replace(/[^\d]/g, '')) || 0;
                    priceInput.data('original-price', originalPrice);
                } else {
                    // Get stored original price
                    originalPrice = priceInput.data('original-price');
                }

                // Calculate new price based on unit selection
                let newPrice;
                if (isLargestUnit) {
                    // If largest unit is selected, use original price
                    newPrice = originalPrice;
                } else {
                    // If smallest unit is selected, divide original price by conversion value
                    newPrice = Math.floor(originalPrice / conversionValue);
                }

                // Update price field with new calculated price
                priceInput.val(UIManager.formatCurrency(newPrice));

                // Recalculate subtotal with new price
                productCalculations.calculateSubtotal(productId);
            });
        },

        calculateSubtotal: (productId) => {
            const quantity = parseInt($(`#product_total_${productId}`).val()) || 0;
            const price = parseInt($(`#product_price_${productId}`).val()?.replace(/[^\d]/g, '')) || 0;
            const discountInput = $(`#product_discount_${productId}`).val();

            let subtotal = quantity * price;

            // Handle discount calculation
            if (discountInput) {
                // Check if discount is a percentage (ends with %)
                if (discountInput.endsWith('%')) {
                    const discountPercentage = parseFloat(discountInput) || 0;
                    subtotal = subtotal * (1 - (discountPercentage / 100));
                } else {
                    // Assume it's a fixed amount
                    const discountAmount = parseInt(discountInput?.replace(/[^\d]/g, '')) || 0;
                    subtotal = subtotal - discountAmount;
                }
            }

            // Ensure subtotal is not negative
            subtotal = Math.max(0, subtotal);

            // Update subtotal field with formatted currency
            $(`#product_subtotal_${productId}`).val(UIManager.formatCurrency(subtotal));

            // Update price field with formatted currency
            $(`#product_price_${productId}`).val(UIManager.formatCurrency(price));

            // Trigger custom event for total calculations
            $(document).trigger('subtotalUpdated');
        }
    };

    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');

        // Initialize all modules
        productCalculations.init();
        eventHandlerProduct.init();
        priceCalculationsPO.init();
        dataServicePurchaseOrder.fetchData();

        // Add initial empty row
        $('#table-body').html(`
            <tr>
                <td id="label_empty_data" colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada produk yang dipilih
                </td>
            </tr>`);

        // Initialize select2 dropdowns
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
