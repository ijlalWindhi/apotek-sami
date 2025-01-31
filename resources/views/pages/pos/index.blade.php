<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form method="POST" class="flex flex-col h-[85vh]" id="form-transaction">
        @csrf
        {{-- Top Section: Customer and Recipe Information --}}
        <div class="p-3">
            <div class="grid grid-cols-3 justify-between items-center gap-2 md:gap-3 w-full">
                <div class="border p-2 rounded-md col-span-3 md:col-span-1 select-small">
                    <label for="customer_type" class="text-sm font-semibold">Pelanggan<span class="text-red-500">*</span>
                        <span class="text-gray-500">[CTRL+ALT+C]</span></label>
                    <select class="js-example-basic-single" id="customer_type" name="customer_type">
                        <option value="Umum" selected>Umum</option>
                        <option value="Rutin">Rutin</option>
                        <option value="Karyawan">Karyawan</option>
                    </select>
                </div>
                <div class="border p-2 rounded-md col-span-3 md:col-span-1">
                    <h2 class="text-sm font-semibold">Resep <span class="text-gray-400">[CTRL+ALT+R]</span></h2>
                    <div class="flex w-full justify-between gap-2 items-center">
                        <p class="text-xs data-recipe" id="recipe">-</p>
                        <div class="flex gap-1">
                            <button id="btn-add-recipe" type="button" data-modal-target="modal-recipe"
                                data-modal-toggle="modal-recipe"
                                class="delete-button font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <x-button color="blue" class="w-full h-full space-x-1" data-modal-target="modal-select-product"
                    data-modal-toggle="modal-select-product">
                    <i class="fa-solid fa-plus"></i>
                    <span class="ms-2">Tambah Produk</span><span class="text-gray-300">[CTRL+ALT+A]</span>
                </x-button>
            </div>
        </div>

        {{-- Product Table with Scrollable Container --}}
        <div class="flex-grow overflow-auto px-3">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg h-full">
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0">
                        <tr>
                            <th scope="col" class="px-3 py-1 min-w-48">Nama</th>
                            <th scope="col" class="px-3 py-1 min-w-32">Jumlah</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Satuan</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Harga</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Tuslah</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Diskon<br />(Rp / %)</th>
                            <th scope="col" class="px-3 py-1 min-w-28">Sub Total</th>
                            <th scope="col" class="px-3 py-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-product-pos">
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400"
                                id="table-body-product-pos-empty">
                                Tidak ada produk yang dipilih
                            </td>
                        </tr>
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bottom Section: Transaction Details and Buttons --}}
        <div class="p-3 bg-white border-t">
            {{-- Transaction Details --}}
            <div class="grid grid-cols-4 justify-between items-center gap-3 w-full mb-3">
                <div class="border p-2 rounded-md col-span-4 md:col-span-1">
                    <label for="notes" class="text-sm font-semibold">Catatan <span
                            class="text-gray-500">[CTRL+ALT+N]</span></label>
                    <input type="text" name="notes" id="notes"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5"
                        placeholder="Catatan transaksi">
                </div>
                <div class="border p-2 rounded-md col-span-4 md:col-span-1 select-small">
                    <label for="payment_type" class="text-sm font-semibold">Metode Pembayaran<span
                            class="text-red-500">*</span> <span class="text-gray-500">[CTRL+ALT+P]</span></label>
                    <select class="js-example-basic-single" id="payment_type" name="payment_type" required>
                        <option value="" selected disabled hidden>Pilih Tipe Pembayaran</option>
                        @foreach ($paymentTypes as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="border p-2 rounded-md col-span-4 md:col-span-1 select-small">
                    <label for="status_transaction" class="text-sm font-semibold">Status<span
                            class="text-red-500">*</span> <span class="text-gray-500">[CTRL+ALT+T]</span></label>
                    <select class="js-example-basic-single" id="status_transaction" name="status_transaction">
                        <option value="Terbayar" selected>Terbayar</option>
                        <option value="Proses">Proses</option>
                        <option value="Tertunda">Tertunda</option>
                    </select>
                </div>
                <div class="border p-2 rounded-md col-span-4 md:col-span-1">
                    <label for="code" class="text-sm font-semibold">No. Invoice<span
                            class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code"
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5"
                        placeholder="Terisi otomatis" readonly>
                </div>
            </div>

            {{-- Financial Summary --}}
            <div class="grid grid-cols-4 justify-between items-center gap-3 w-full mb-3">
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1">
                    <label for="discount" class="text-sm font-semibold">Diskon (Rp / %) <span
                            class="text-gray-500">[CTRL+ALT+D]</span></label>
                    <input type="text" name="discount" id="discount" value="0"
                        class="bg-transparent border-transparent text-gray-900 text-xl font-semibold focus:ring-transparent focus:border-transparent block w-full p-0">
                </div>
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1">
                    <label for="paid_amount" class="text-sm font-semibold">Dibayarkan<span
                            class="text-red-500">*</span> <span class="text-gray-500">[CTRL+ALT+G]</span></label>
                    <div class="flex items-center">
                        <p class="text-xl font-semibold">Rp</p>
                        <input type="number" name="paid_amount" id="paid_amount" step="1" value="0"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="bg-transparent border-transparent text-gray-900 text-xl font-semibold focus:ring-transparent focus:border-transparent block w-full p-0"
                            required min="1">
                    </div>
                </div>
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1 text-red-500">
                    <h2 class="text-sm font-semibold">Kembalian</h2>
                    <p class="text-xl font-semibold mt-1" id="change_amount">Rp0</p>
                </div>
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1 text-green-500">
                    <h2 class="text-sm font-semibold">Total</h2>
                    <p class="text-xl font-semibold mt-1" id="total_amount">Rp0</p>
                </div>
            </div>

            {{-- Transaction Buttons --}}
            <div class="grid grid-cols-3 justify-between items-center gap-3 w-full">
                <x-button color="red" id="btn-clear-form" class="w-full space-x-1">
                    <i class="fa-solid fa-trash"></i>
                    <span class="ms-2">Bersihkan Form</span><span class="text-gray-300">[CTRL+ALT+W]</span>
                </x-button>
                <x-button color="gray" id="btn-search-transaction" class="w-full space-x-1"
                    data-modal-target="modal-search-transaction" data-modal-toggle="modal-search-transaction">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="ms-2">Cari Transaksi</span><span class="text-gray-300">[CTRL+ALT+S]</span>
                </x-button>
                <x-button color="green" id="btn-save-transaction" class="w-full space-x-1" type="submit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span class="ms-2">Simpan Transaksi</span><span class="text-gray-300">[F9]</span>
                </x-button>
            </div>
        </div>
    </form>

    {{-- Modal --}}
    <x-pages.pos.modal-recipe :users="$users"></x-pages.pos.modal-recipe>
    <x-pages.pos.modal-select-product></x-pages.pos.modal-select-product>
    <x-pages.pos.modal-search-transaction></x-pages.pos.modal-search-transaction>
</x-layout>

<script>
    // Constants
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 999999;

    function resetForm() {
        // Clear product list
        document.getElementById('table-body-product-pos').innerHTML = `
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400" id="table-body-product-pos-empty">
                                Tidak ada produk yang dipilih
                            </td>
                        </tr>`;
        // Reset all form fields to 0
        document.getElementById('notes').value = '';
        document.getElementById('discount').value = '0';
        document.getElementById('paid_amount').value = '0';
        $('#payment_type').val(null).trigger('change.select2');
        $('#status_transaction').val('Terbayar').trigger('change.select2');
        document.querySelector('.text-red-500 p').innerText = 'Rp0';
        document.querySelector('.text-green-500 p').innerText = 'Rp0';
        document.getElementById('recipe').innerText = '-';
        document.getElementById('recipe').removeAttribute('data-id');
    }

    function printReceipt(data) {
        // Open receipt in new window
        const receiptWindow = window.open('{{ route('pos.receipt') }}', 'Receipt', 'width=400,height=600');

        receiptWindow.onload = function() {
            // Get all products from the table
            const products = [];
            if (data?.products) {
                data.products.forEach(product => {
                    products.push({
                        name: product.product.name,
                        quantity: parseInt(product.qty),
                        subtotal: UIManager.formatCurrency(parseInt(product.subtotal))
                    });
                });
            } else {
                const productRows = $("#table-body-product-pos tr").not(
                    ":has(td[colspan])"
                );
                productRows.each(function() {
                    const row = $(this);
                    const productId = row.find('input[id^="product_pos_id_"]').val();

                    if (productId) {
                        const name = row.find(`td[id^="product_pos_name_${productId}"]`).text();
                        const quantity = row.find(`input[id^="product_pos_total_${productId}"]`).val()
                        const subtotal = row.find(`input[id^="product_pos_subtotal_${productId}"]`).val()

                        products.push({
                            name,
                            quantity,
                            subtotal
                        });
                    }
                });
            }

            // Update receipt content
            const doc = receiptWindow.document;
            doc.getElementById('invoice-number').innerText = data?.invoice_number || '-';
            doc.getElementById('transaction-date').innerText = formatDatePrint(new Date(data.created_at));
            doc.getElementById('cashier-name').innerText = '{{ auth()->user()->name }}';

            // Update products table
            const tbody = doc.querySelector('#items-table tbody');
            tbody.innerHTML = products.map(product => `
            <tr>
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td class="amount-column">Rp${product.subtotal}</td>
            </tr>
        `).join('');

            // Update totals
            doc.getElementById('subtotal').innerText =
                `Rp${UIManager?.formatCurrency(data?.total_before_discount || 0)}`;
            doc.getElementById('discount').innerText = `Rp${UIManager?.formatCurrency(data?.nominal_discount) || 0}`
            doc.getElementById('total').innerText = `Rp${UIManager?.formatCurrency(data?.total_amount) || 0}`;
            doc.getElementById('cash-amount').innerText = `Rp${UIManager?.formatCurrency(data?.paid_amount) || 0}`;
            doc.getElementById('change-amount').innerText =
                `Rp${UIManager?.formatCurrency(data?.change_amount) || 0}`;

            // Print the receipt
            setTimeout(() => {
                receiptWindow.print();
                // Close the window after printing (optional)
                receiptWindow.close();
                resetForm();
            }, 500);
        };
    }

    /**
     * Data Fetching and Processing
     */
    const dataServicePos = {
        /**
         * Create a new transaction
         */
        createTransaction: (data) => {
            uiManager.showScreenLoader();

            $.ajax({
                url: '/pos/transaction',
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

                    if (response?.data?.status === 'Terbayar') {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil menambahkan data",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Print receipt
                        printReceipt(response?.data);
                    } else if (response?.data?.status === 'Proses' || response?.data?.status ===
                        'Tertunda') {
                        Swal.fire({
                            title: 'Berhasil menambahkan data',
                            html: '<p class="text-sm">Apakah anda ingin mencetak struk pembelian?</p>',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                printReceipt(response?.data);
                            } else {
                                resetForm();
                            }
                        })
                    }
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data pajak. Silahkan coba lagi.');
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                }
            });
        },
    }

    /**
     * Event Handlers
     */
    const eventHandlerPos = {
        init: () => {
            // Clear Form
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'w') {
                    event.preventDefault();
                    resetForm();
                }
            });
            $('body').on('click', '#btn-clear-form', function() {
                event.preventDefault();
                resetForm();
            });

            // Open Recipe Modal
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'r') {
                    event.preventDefault();
                    document.querySelector('[data-modal-target="modal-recipe"]').click();
                }
            });

            // Open Search Transaction Modal
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 's') {
                    event.preventDefault();
                    document.querySelector('[data-modal-target="modal-search-transaction"]').click();
                }
            });

            // Open Select Product Modal
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'a') {
                    event.preventDefault();
                    document.querySelector('[data-modal-target="modal-select-product"]').click();
                }
            });

            // Focus on input notes
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'n') {
                    document.getElementById('notes').focus();
                }
            });

            // Focus on input payment type
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'p') {
                    $('#customer_type').select2('close');
                    $('#status_transaction').select2('close');
                    $('#payment_type').select2('open');
                }
            });

            // Focus on input status transaction
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 't') {
                    $('#payment_type').select2('close');
                    $('#customer_type').select2('close');
                    $('#status_transaction').select2('open');
                }
            });

            // Focus on input customer type
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'c') {
                    $('#payment_type').select2('close');
                    $('#status_transaction').select2('close');
                    $('#customer_type').select2('open');
                }
            });

            // Focus on input discount
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'd') {
                    document.getElementById('discount').value = '';
                    document.getElementById('discount').focus();
                }
            });

            // Focus on input customer payment
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'g') {
                    document.getElementById('paid_amount').value = '';
                    document.getElementById('paid_amount').focus();
                }
            });

            // Save Transaction
            document.addEventListener('keydown', function(event) {
                if (event.key === 'F9') {
                    event.preventDefault();
                    document.getElementById('btn-save-transaction').click();
                }
            });
            $("form#form-transaction").on('submit', function(event) {
                event.preventDefault();
                const data = formattedDataTransaction({
                    created_by: '{{ auth()->user()->id }}'
                });
                dataServicePos.createTransaction(data);
            });
        },
    };

    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        priceCalculationsPOS.init();
        eventHandlerPos.init();

        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
