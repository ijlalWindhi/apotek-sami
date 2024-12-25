<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="product" class="flex flex-col justify-between w-full h-full">
        @csrf
        <!-- Product Tab -->
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="me-2" role="presentation">
                    <button type="button"
                        class="tab-button inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 text-blue-600 border-blue-600"
                        data-tab="info" aria-selected="true">
                        Informasi Produk
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button type="button"
                        class="tab-button inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        data-tab="price" aria-selected="false">
                        Informasi Harga
                    </button>
                </li>
            </ul>
        </div>

        <div id="tab-contents">
            <!-- Informasi Produk Tab -->
            <div id="info" role="tabpanel" aria-labelledby="info-tab"
                class="grid gird-cols-1 md:grid-cols-2 items-start justify-between gap-4">
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
                    <label for="drug_group"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Golongan Obat
                        <span class="text-red-500">*</span></label>
                    <select name="drug_group" id="drug_group" required
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
                    <label for="minimum_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok
                        Minimum
                        <span class="text-red-500">*</span></label>
                    <input type="number" name="minimum_stock" id="minimum_stock"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Stok Minimum" required>
                </div>
                <div>
                    <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier
                        <span class="text-red-500">*</span></label>
                    <select name="supplier" id="supplier" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="" selected disabled hidden>Pilih supplier produk</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-4 items-start justify-start">
                    <div class="w-full">
                        <label for="is_active"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                            <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" selected disabled hidden>Pilih status</option>
                            <option value="true">Aktif</option>
                            <option value="false">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Catatan"></textarea>
                    </div>
                </div>
                <div id="additional-units" class="flex flex-col justify-start items-start w-full gap-2">
                    <div class="w-full">
                        <label for="unit"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan
                            Dasar
                            <span class="text-red-500">*</span></label>
                        <select name="unit" id="unit" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" selected disabled hidden>Pilih satuan produk</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-button id="btn-add-unit" color="blue" class="w-full">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Tambah Satuan Lainnya</x-button>
                </div>
            </div>

            <!-- Informasi Harga Tab -->
            <div class="hidden" id="price" role="tabpanel" aria-labelledby="price-tab">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-1">
                        <label for="purchase_price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                            Beli <span class="text-red-500">*</span></label>
                        <input type="text" step="0.01" name="purchase_price" id="purchase_price" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    </div>
                    <div class="col-span-1">
                        <label for="selling_price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                            Jual <span class="text-red-500">*</span></label>
                        <input type="text" step="0.01" name="selling_price" id="selling_price" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    </div>

                    {{-- Margin --}}
                    <div class="col-span-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_margin" id="show_margin" class="sr-only peer"
                                value="1">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tampilkan
                                Margin</span>
                            <i class="fa-solid fa-info-circle text-xs ml-2"
                                data-tooltip-target="information-margin"></i>
                        </label>
                        <div id="information-margin" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-blue-500 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Margin = (Harga Jual - Harga Beli) / Harga Beli
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    <div class="col-span-1 margin-fields hidden">
                        <label for="margin_display"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Margin
                            (%)</label>
                        <input type="text" id="margin_display"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <input type="hidden" name="margin_percentage" id="margin_percentage">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row mt-4 md:mt-10">
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

            // Add additional unit
            $('#btn-add-unit').on('click', function(e) {
                if ($('#unit option:selected').val() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: 'Pilih satuan dasar terlebih dahulu',
                    });
                    return;
                }
                e.preventDefault();
                const label =
                    `<p class="text-sm font-medium text-gray-900 dark:text-white additional-unit">Satuan Lainnya</p>`;
                if (unitCount === 0) {
                    $('#additional-units').append(label);
                }
                unitCount++;

                const unitSelect = `
                                <div class="flex w-full justify-between items-center gap-2 additional-unit">
                                    <div class="flex w-fit items-center gap-2 bg-gray-50 border border-gray-300 rounded-lg">
                                        <input type="number" name="additional_conversion_${unitCount}" value="1"
                                            class="bg-gray-50 border-transparent text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-20 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            required />
                                        X
                                        <select name="additional_unit_${unitCount}"
                                            class="bg-gray-50 border-transparent text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-32 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="" selected disabled hidden>Pilih satuan produk</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    =
                                    <div class="flex w-fit items-center bg-gray-50 border border-gray-300 rounded-lg">
                                        <input type="number" name="additional_conversion_${unitCount}" value="1"
                                            class="bg-gray-50 border-transparent text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-20 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            required />
                                        <span class="text-gray-900 dark:text-white text-sm p-2.5">${
                                            $('#unit option:selected').text()
                                            }</span>
                                    </div>
                                    <button type="button"
                                        class="btn-remove-unit text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            `;

                $('#additional-units').append(unitSelect);
            });

            // Remove additional unit
            $('body').on('click', '.btn-remove-unit', function() {
                $(this).closest('.additional-unit').remove();
                unitCount--;

                if (unitCount === 0) {
                    $('.additional-unit').remove();
                }
            });

            // Change unit
            $('#unit').on('change', function() {
                $('.additional-unit').remove();
                unitCount = 0;
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersProduct.init();
        TabManager.init();
        initEventListeners();
    });
</script>
