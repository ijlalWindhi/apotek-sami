<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col h-[85vh]">
        {{-- Top Section: Customer and Recipe Information --}}
        <div class="p-3">
            <div class="grid grid-cols-3 justify-between items-center gap-2 md:gap-3 w-full">
                <div class="border p-2 rounded-md col-span-3 md:col-span-1 select-small">
                    <label for="customer_type" class="text-sm font-semibold">Pelanggan<span
                            class="text-red-500">*</span></label>
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
                            <button id="btn-add-recipe" data-modal-target="modal-recipe"
                                data-modal-toggle="modal-recipe"
                                class="delete-button font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <x-button color="blue" class="w-full h-full space-x-1">
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
                    <tbody id="table-body-product-recipe">
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
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
                    <label for="description" class="text-sm font-semibold">Catatan <span
                            class="text-gray-500">[CTRL+ALT+N]</span></label>
                    <input type="text" name="description" id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5"
                        placeholder="Catatan transaksi">
                </div>
                <div class="border p-2 rounded-md col-span-4 md:col-span-1 select-small">
                    <label for="payment_type" class="text-sm font-semibold">Metode Pembayaran <span
                            class="text-gray-500">[CTRL+ALT+P]</span><span class="text-red-500">*</span></label>
                    <select class="js-example-basic-single" id="payment_type" name="payment_type">
                        <option value="" selected disabled hidden>Pilih Tipe Pembayaran</option>
                        @foreach ($paymentTypes as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="border p-2 rounded-md col-span-4 md:col-span-1 select-small">
                    <label for="status_transaction" class="text-sm font-semibold">Status<span
                            class="text-red-500">*</span></label>
                    <select class="js-example-basic-single" id="status_transaction" name="status_transaction">
                        <option value="Terbayar" selected>Terbayar</option>
                        <option value="Belum Lunas">Belum Lunas</option>
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
                    <label for="discount" class="text-sm font-semibold">Diskon (Rp / %)</label>
                    <input type="text" name="discount" id="discount" value="0"
                        class="bg-transparent border-transparent text-gray-900 text-xl font-semibold focus:ring-transparent focus:border-transparent block w-full p-0">
                </div>
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1">
                    <label for="customer_payment" class="text-sm font-semibold">Dibayarkan<span
                            class="text-red-500">*</span></label>
                    <div class="flex items-center">
                        <p class="text-xl font-semibold">Rp</p>
                        <input type="number" name="customer_payment" id="customer_payment" step="1"
                            value="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="bg-transparent border-transparent text-gray-900 text-xl font-semibold focus:ring-transparent focus:border-transparent block w-full p-0"
                            required>
                    </div>
                </div>
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1 text-red-500">
                    <h2 class="text-sm font-semibold">Kembalian</h2>
                    <p class="text-xl font-semibold mt-1">Rp0</p>
                </div>
                <div class="border p-2 rounded-md h-20 col-span-3 md:col-span-1 text-green-500">
                    <h2 class="text-sm font-semibold">Total</h2>
                    <p class="text-xl font-semibold mt-1">Rp0</p>
                </div>
            </div>

            {{-- Transaction Buttons --}}
            <div class="grid grid-cols-3 justify-between items-center gap-3 w-full">
                <x-button color="red" id="btn-clear-form" class="w-full space-x-1">
                    <i class="fa-solid fa-trash"></i>
                    <span class="ms-2">Bersihkan Form</span><span class="text-gray-300">[CTRL+ALT+W]</span>
                </x-button>
                <x-button color="gray" id="btn-search-transaction" class="w-full space-x-1">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="ms-2">Cari Transaksi</span><span class="text-gray-300">[CTRL+ALT+S]</span>
                </x-button>
                <x-button color="green" id="btn-save-transaction" class="w-full space-x-1" id="btn-payment">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span class="ms-2">Simpan Transaksi</span><span class="text-gray-300">[F9]</span>
                </x-button>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <x-pages.pos.modal-recipe :users="$users"></x-pages.pos.modal-recipe>
</x-layout>

<script>
    // Constants
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 999999;

    function resetForm() {
        event.preventDefault();
        // Clear product list
        document.getElementById('table-body-product-recipe').innerHTML = `
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada produk yang dipilih
                            </td>
                        </tr>`;
        // Reset all form fields to 0
        document.getElementById('description').value = '';
        document.getElementById('discount').value = '0';
        document.getElementById('customer_payment').value = '0';
        $('#payment_type').val(null).trigger('change.select2');
        $('#status_transaction').val('Terbayar').trigger('change.select2');
        document.querySelector('.text-red-500 p').innerText = 'Rp0';
        document.querySelector('.text-green-500 p').innerText = 'Rp0';
        document.getElementById('recipe').innerText = '-';
        document.getElementById('recipe').removeAttribute('data-id');
    }

    /**
     * Event Handlers
     */
    const eventHandlerPos = {
        init: () => {
            // Clear Form
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'w') {
                    resetForm();
                }
            });
            $('body').on('click', '#btn-clear-form', resetForm);

            // Focus on input description
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'n') {
                    document.getElementById('description').focus();
                }
            });

            // Focus on input payment type
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'p') {
                    $('#payment_type').select2('open');
                }
            });
        },
    };

    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        priceCalculationsPOS.init();
        eventHandlerPos.init();

        $("body").on('click', '#btn-payment', function() {
            const doctor_id = $('#doctor').attr('data-id');
        });

        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
