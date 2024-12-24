<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form class="flex flex-col gap-4 md:gap-10 justify-between w-full h-full">
        @csrf
        <div class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start justify-between gap-4">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode
                    <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Nama supplier" required>
            </div>
            <div>
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe Supplier
                    <span class="text-red-500">*</span></label>
                <select name="type" id="type" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih tipe supplier</option>
                    <option value="Pedagang Besar Farmasi">Pedaan Besar Farmasi</option>
                    <option value="Apotek Lain">Apotek Lain</option>
                    <option value="Toko Obat">Toko Obat</option>
                    <option value="Lain-Lain">Lain-Lain</option>
                </select>
            </div>
            <div>
                <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode
                    <span class="text-red-500">*</span></label>
                <input type="text" name="code" id="code" disabled
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                    placeholder="Terisi otomatis">
            </div>
            <div>
                <label for="payment_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                    Pembayaran
                    <span class="text-red-500">*</span></label>
                <select name="payment_type" id="payment_type" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih Tipe Pembayaran</option>
                    @foreach ($payment_type as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="payment_term" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jangka
                    Waktu
                    Pembayaran
                    <span class="text-red-500">*</span></label>
                <select name="payment_term" id="payment_term" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih Jangka Waktu Pembayaran</option>
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
                <label for="is_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                    <span class="text-red-500">*</span></label>
                <select name="is_active" id="is_active" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih status</option>
                    <option value="true">Aktif</option>
                    <option value="false">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label for="phone_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon
                    1</label>
                <input type="text" name="phone_1" id="phone_1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Nomor Telepon 1">
            </div>
            <div>
                <label for="phone_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon
                    2</label>
                <input type="text" name="phone_2" id="phone_2"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Nomor Telepon 2">
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                </label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Email">
            </div>
            <div>
                <label for="postal_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos
                </label>
                <input type="text" name="postal_code" id="postal_code"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Kode Pos">
            </div>
            <div>
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat
                </label>
                <textarea id="address" name="address" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Catatan"></textarea>
            </div>
            <div>
                <label for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                <textarea id="description" name="description" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Catatan"></textarea>
            </div>
        </div>
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('supplier.index') }}">
                <x-button color="red" class="w-full md:w-32">Batal</x-button>
            </a>
            <x-button color="blue" type="submit" class="w-full md:w-32">Simpan</x-button>
        </div>
    </form>
</x-layout>

<script>
    /**
     * Create Supplier Management Module
     * Handles the creation of a new supplier
     */

    /**
     * Data Fetching and Processing
     */
    const dataService = {
        /**
         * Fetches supplier data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (data) => {
            uiManager.showScreenLoader();

            $.ajax({
                url: '/inventory/master/supplier',
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
                        window.location.href = '/inventory/master/supplier';
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
    const eventHandlersSupplier = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Search input handler with debounce
            let searchTimeout;
            $('form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serializeArray();
                let data = {};

                $.each(formData, function() {
                    if (this.name === 'is_active') {
                        this.value = this.value === 'true';
                    }
                    data[this.name] = this.value;
                });

                dataService.fetchData(data);
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersSupplier.init();
    });
</script>
