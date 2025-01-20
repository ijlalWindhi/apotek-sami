<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="product" class="flex flex-col justify-between w-full h-full">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start justify-between gap-4">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Nama produk" required>
            </div>
            <div>
                <label for="sku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode
                    Produk
                    (SKU)
                    <span class="text-red-500">*</span></label>
                <div class="flex w-full justify-between items-center gap-2">
                    <input type="text" name="sku" id="sku" required placeholder="Kode Produk"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    <button type="button" id="btn-generate-sku"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fa-solid fa-sync"></i>
                    </button>
                </div>
            </div>
            <div>
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                    Produk
                    <span class="text-red-500">*</span></label>
                <select name="type" id="type" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih tipe produk</option>
                    <option value="Obat">Obat</option>
                    <option value="Alat Kesehatan">Alat Kesehatan</option>
                    <option value="Umum">Umum</option>
                    <option value="Lain-Lain">Lain-Lain</option>
                </select>
            </div>
            <div>
                <label for="drug_group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Golongan
                    Obat</label>
                <select name="drug_group" id="drug_group"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih golongan obat</option>
                    <option value="Obat Bebas">Obat Bebas</option>
                    <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                    <option value="Obat Keras">Obat Keras</option>
                    <option value="Obat Golongan Narkotika">Obat Golongan Narkotika</option>
                    <option value="Obat Fitofarmaka">Obat Fitofarmaka</option>
                    <option value="Obat Herbal Terstandar (OHT)">Obat Herbal Terstandar (OHT)</option>
                    <option value="Obat Herbal (Jamu)">Obat Herbal (Jamu)</option>
                </select>
            </div>
            <div>
                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier
                    <span class="text-red-500">*</span></label>
                <select name="supplier_id" id="supplier_id" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih supplier produk</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
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
                <label for="minimum_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok
                    Minimum (Satuan Terkecil)
                    <span class="text-red-500">*</span></label>
                <input type="number" name="minimum_stock" id="minimum_stock"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Stok Minimum" required>
            </div>
            <div class="col-span-1 lg:col-span-2">
                <label for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                <input id="description" name="description" type="text"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Catatan" />
            </div>
            <div>
                <label for="largest_unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan
                    Terbesar
                    <span class="text-red-500">*</span></label>
                <select name="largest_unit" id="largest_unit" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih satuan produk</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->symbol }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="smallest_unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan
                    Terkecil
                    <span class="text-red-500">*</span></label>
                <select name="smallest_unit" id="smallest_unit" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih satuan produk</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->symbol }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="conversion_value"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koversi
                    <span class="text-red-500">*</span></label>
                <input type="number" name="conversion_value" id="conversion_value" required placeholder="Koversi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
            <div>
                <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                    Beli (Satuan Terbesar) <span class="text-red-500">*</span></label>
                <input type="text" step="0.01" name="purchase_price" id="purchase_price" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
            </div>
            <div>
                <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                    Jual (Satuan Terbesar)<span class="text-red-500">*</span></label>
                <input type="text" step="0.01" name="selling_price" id="selling_price" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
            </div>
            <div>
                <label for="margin_display"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Margin
                    (%) <i class="fa-solid fa-info-circle text-xs cursor-pointer"
                        data-tooltip-target="margin-information"></i></label>
                <div id="margin-information" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Margin = (Harga Jual - Harga Beli) / Harga Beli
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>

                <input type="text" id="margin_display"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                <input type="hidden" name="margin_percentage" id="margin_percentage">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row mt-4">
            <a href="{{ route('product.index') }}" class="w-full md:w-32">
                <x-button color="red" class="w-full md:w-32">Batal</x-button>
            </a>
            <x-button color="blue" type="submit" class="w-full md:w-32">Simpan</x-button>
        </div>
    </form>
</x-layout>

<script>
    // Constants
    let unitCount = 0;

    // Data Fetching and Processing
    const dataServiceProduct = {
        /**
         * Creates a new product
         * @param {Object} data - Product data
         */
        createProduct: (data) => {
            uiManager.showScreenLoader();

            $.ajax({
                url: '/inventory/pharmacy/product',
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
                        window.location.href = '/inventory/pharmacy/product';
                    }, 300);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
            });
        },
    };

    // Event Handlers
    const eventHandlersProduct = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Submit form
            $('form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serializeArray();
                const formattedData = UtilsProduct.formatRequestData(formData);
                dataServiceProduct.createProduct(formattedData);
            });

            // Generate SKU
            $('body').on('click', '#btn-generate-sku', function() {
                const sku = `SKU-${Math.random().toString(36).substring(2, 8).toUpperCase()}`;
                $('#sku').val(sku);
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersProduct.init();
        initEventListeners();
    });
</script>
