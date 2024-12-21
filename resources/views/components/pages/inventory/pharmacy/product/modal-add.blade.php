@props(['units'])

{{-- Button Add --}}
<x-button color="blue" data-modal-target="modal-add-product" data-modal-toggle="modal-add-product">
    <i class="fa-solid fa-plus"></i>
    <span class="ms-2">Tambah Produk</span>
</x-button>

{{-- Modal --}}
<div id="modal-add-product" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Tambah Produk
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-product">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="create-product" method="POST">
                @csrf
                <div class="col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Produk<span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                </div>

                <!-- Tabs -->
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

                <!-- Tab Contents -->
                <div id="tab-contents" class="h-56 overflow-y-auto">
                    <!-- Informasi Produk Tab -->
                    <div class="block" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-1">
                                <label for="status"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status<span
                                        class="text-red-500">*</span></label>
                                <select name="status" id="status" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    <option value="1">Dijual</option>
                                    <option value="0">Tidak Dijual</option>
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="sku"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SKU
                                    Produk<span class="text-red-500">*</span></label>
                                <div class="flex w-full justify-between items-center gap-2">
                                    <input type="text" name="sku" id="sku" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    <button type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <i class="fa-solid fa-sync"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <label for="category_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori<span
                                        class="text-red-500">*</span></label>
                                <select name="category_id" id="category_id" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="unit_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan<span
                                        class="text-red-500">*</span></label>
                                <select name="unit_id" id="unit_id" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="manufacturer"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pabrik</label>
                                <input type="text" name="manufacturer" id="manufacturer"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                            <div class="col-span-1">
                                <label for="minimum_stock"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok
                                    Minimal<span class="text-red-500">*</span></label>
                                <input type="number" name="minimum_stock" id="minimum_stock" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                            <div class="col-span-2">
                                <label for="notes"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Harga Tab -->
                    <div class="hidden" id="price" role="tabpanel" aria-labelledby="price-tab">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-1">
                                <label for="purchase_price"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                                    Beli<span class="text-red-500">*</span></label>
                                <input type="text" step="0.01" name="purchase_price" id="purchase_price"
                                    required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                            <div class="col-span-1">
                                <label for="selling_price"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                                    Jual<span class="text-red-500">*</span></label>
                                <input type="text" step="0.01" name="selling_price" id="selling_price"
                                    required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            {{-- Markup Margin --}}
                            <div class="col-span-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_markup_margin" id="show_markup_margin"
                                        class="sr-only peer" value="1">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tampilkan
                                        Mark-Up dan Margin</span>
                                </label>
                            </div>
                            <div class="col-span-1 markup-margin-fields hidden">
                                <label for="markup_display"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mark-Up
                                    (%)</label>
                                <input type="text" id="markup_display"
                                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <input type="hidden" name="markup_percentage" id="markup_percentage">
                            </div>
                            <div class="col-span-1 markup-margin-fields hidden">
                                <label for="margin_display"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Margin
                                    (%)</label>
                                <input type="text" id="margin_display"
                                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <input type="hidden" name="margin_percentage" id="margin_percentage">
                            </div>

                            {{-- Tuslah --}}
                            <div class="col-span-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_overhead_cost" id="show_overhead_cost"
                                        class="sr-only peer" value="1">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Tampilkan Biaya Overhead (Tuslah)
                                    </span>
                                </label>
                            </div>
                            <div class="col-span-2 overhead-cost-fields hidden">
                                <label for="overhead_display"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Biaya Overhead (%)
                                </label>
                                <input type="text" id="overhead_display"
                                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <input type="hidden" name="overhead_cost_value" id="overhead_cost_value">
                            </div>
                            <div class="col-span-2 overhead-cost-fields hidden">
                                <label for="overhead_cost_description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Keterangan Biaya Overhead
                                </label>
                                <textarea name="overhead_cost_description" id="overhead_cost_description" rows="2"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-2">
                    <i class="fa-solid fa-save me-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selector Constants
        const SELECTORS = {
            markupMarginToggle: '#show_markup_margin',
            overheadCostToggle: '#show_overhead_cost',
            markupMarginFields: '.markup-margin-fields',
            purchasePrice: '#purchase_price',
            sellingPrice: '#selling_price',
            markupDisplay: '#markup_display',
            marginDisplay: '#margin_display',
            markupPercentage: '#markup_percentage',
            marginPercentage: '#margin_percentage',
            tabButtons: '.tab-button',
            createProductForm: '#create-product',
            overheadDisplay: '#overhead_display'
        };

        // Enhanced UIManager with Separate Formatting
        const UIManager = {
            // Formatting untuk input yang terkait dengan uang (harga)
            formatCurrency: function(number, options = {}) {
                const {
                    decimalPlaces = 0,
                        useGrouping = true
                } = options;

                const numValue = parseFloat(number);
                if (isNaN(numValue)) return '0';

                return numValue.toLocaleString('id-ID', {
                    minimumFractionDigits: decimalPlaces,
                    maximumFractionDigits: decimalPlaces,
                    useGrouping: useGrouping
                });
            },

            // Formatting untuk input persentase (mendukung desimal)
            formatPercentage: function(number, options = {}) {
                const {
                    decimalPlaces = 2,
                        maxValue = 100
                } = options;

                const numValue = parseFloat(number);
                if (isNaN(numValue)) return '0,00';

                // Batasi nilai maksimal
                const constrainedValue = Math.min(numValue, maxValue);

                // Gunakan toFixed untuk presisi desimal, kemudian ganti titik dengan koma
                return constrainedValue.toFixed(decimalPlaces).replace('.', ',');
            },

            // Parse input mata uang
            parseCurrency: function(formattedValue) {
                if (typeof formattedValue !== 'string') return 0;

                // Hapus titik sebagai pemisah ribuan
                const cleanedValue = formattedValue.replace(/\./g, '');

                const parsedValue = parseFloat(cleanedValue);
                return isNaN(parsedValue) ? 0 : parsedValue;
            },

            // Parse input persentase
            parsePercentage: function(formattedValue) {
                if (typeof formattedValue !== 'string') return 0;

                // Normalisasi input - ganti koma dengan titik untuk parsing
                const cleanedValue = formattedValue.replace(',', '.');

                const parsedValue = parseFloat(cleanedValue);
                return isNaN(parsedValue) ? 0 : parsedValue;
            },

            // Attach formatting untuk input mata uang
            attachCurrencyFormatting: function(inputElement, options = {}) {
                const {
                    decimalPlaces = 0
                } = options;

                inputElement.type = 'text';
                inputElement.value = '0';

                inputElement.addEventListener('input', (event) => {
                    const cursorPosition = event.target.selectionStart;

                    // Bersihkan input dari karakter non-numerik
                    let value = event.target.value.replace(/[^0-9]/g, '');

                    const formattedValue = this.formatCurrency(value, {
                        decimalPlaces: decimalPlaces,
                        useGrouping: true
                    });

                    event.target.value = formattedValue;

                    const newValue = event.target.value;
                    const addedDots = (newValue.match(/\./g) || []).length;
                    const newCursorPosition = Math.max(cursorPosition + addedDots, 0);
                    event.target.setSelectionRange(newCursorPosition, newCursorPosition);
                });

                inputElement.addEventListener('focus', (event) => {
                    if (event.target.value === '0') {
                        event.target.value = '';
                    }
                });

                inputElement.addEventListener('blur', (event) => {
                    if (event.target.value.trim() === '') {
                        event.target.value = '0';
                    } else {
                        event.target.value = this.formatCurrency(
                            this.parseCurrency(event.target.value), {
                                decimalPlaces: decimalPlaces,
                                useGrouping: true
                            }
                        );
                    }
                });
            },

            // Attach formatting untuk input persentase
            attachPercentageFormatting: function(inputElement, options = {}) {
                const {
                    decimalPlaces = 2,
                        maxValue = 100 // Batasi maksimal 100%
                } = options;

                inputElement.type = 'text';
                inputElement.value = '0,00'; // Gunakan koma untuk desimal Indonesia

                inputElement.addEventListener('input', (event) => {
                    // Izinkan input numerik, koma, dan titik
                    let value = event.target.value.replace(/[^0-9,\.]/g, '');

                    // Normalisasi desimal - ganti titik atau koma ke format Indonesia
                    value = value.replace('.', ',');

                    // Batasi jumlah koma
                    const commaCount = (value.match(/,/g) || []).length;
                    if (commaCount > 1) {
                        // Hapus koma tambahan
                        value = value.replace(/,/g, '').replace(/(\d+)(\d{2})$/, '$1,$2');
                    }

                    // Batasi panjang input
                    if (value.length > 6) {
                        value = value.slice(0, 6);
                    }

                    event.target.value = value;

                    // Parse dan validasi nilai
                    const parsedValue = this.parsePercentage(value);

                    // Batasi maksimal 100%
                    if (parsedValue > 100) {
                        event.target.value = '100,00';
                    }
                });

                inputElement.addEventListener('focus', (event) => {
                    // Hapus '0,00' saat difokus
                    if (event.target.value === '0,00') {
                        event.target.value = '';
                    }
                });

                inputElement.addEventListener('blur', (event) => {
                    let value = event.target.value.trim();

                    // Kembalikan ke '0,00' jika kosong
                    if (value === '' || value === ',') {
                        event.target.value = '0,00';
                        return;
                    }

                    // Pastikan ada digit desimal
                    if (!value.includes(',')) {
                        value += ',00';
                    }

                    // Tambahkan nol di belakang koma jika kurang dari 2 digit
                    const parts = value.split(',');
                    if (parts[1].length === 1) {
                        value += '0';
                    }

                    // Format dan batasi maksimal 100%
                    const parsedValue = this.parsePercentage(value);
                    const formattedValue = this.formatPercentage(
                        Math.min(parsedValue, 100), {
                            decimalPlaces: decimalPlaces
                        }
                    );

                    event.target.value = formattedValue;
                });
            },

            toggleMarkupMarginFields: function(isChecked) {
                const fields = document.querySelectorAll(SELECTORS.markupMarginFields);
                fields.forEach(field => field.classList.toggle('hidden', !isChecked));
            },

            toggleOverheadCostFields: function(isChecked) {
                const fields = document.querySelectorAll('.overhead-cost-fields');
                fields.forEach(field => field.classList.toggle('hidden', !isChecked));
            },
        };

        // Price Calculation Module
        const PriceCalculator = {
            calculateMarkup: function(purchasePrice, sellingPrice) {
                // Markup = (Selling Price - Purchase Price) / Purchase Price * 100
                return purchasePrice && sellingPrice ?
                    ((sellingPrice - purchasePrice) / purchasePrice) * 100 :
                    0;
            },

            calculateMargin: function(purchasePrice, sellingPrice) {
                // Margin = (Selling Price - Purchase Price) / Selling Price * 100
                return purchasePrice && sellingPrice ?
                    ((sellingPrice - purchasePrice) / sellingPrice) * 100 :
                    0;
            },

            calculateOverheadCost: function(purchasePrice, overheadPercentage) {
                return purchasePrice * (overheadPercentage / 100);
            },

            calculateSellingPriceByMarkup: function(purchasePrice, markupPercentage) {
                // Selling Price = Purchase Price * (1 + Markup%)
                return purchasePrice * (1 + (markupPercentage / 100));
            },

            calculateSellingPriceByMargin: function(purchasePrice, marginPercentage) {
                // Selling Price = Purchase Price / (1 - Margin%)
                return purchasePrice / (1 - (marginPercentage / 100));
            },

            calculateSellingPriceWithOverhead: function(purchasePrice, markupPercentage,
                overheadPercentage) {
                // Hitung biaya overhead
                const overheadCost = this.calculateOverheadCost(purchasePrice, overheadPercentage);

                // Total biaya adalah harga beli ditambah overhead
                const totalCost = purchasePrice + overheadCost;

                // Hitung harga jual dengan markup dari total biaya
                return totalCost * (1 + (markupPercentage / 100));
            }
        };

        // Price Handling Module
        const PriceHandler = {
            updatePriceCalculations: function() {
                const purchasePriceInput = document.querySelector(SELECTORS.purchasePrice);
                const sellingPriceInput = document.querySelector(SELECTORS.sellingPrice);
                const markupDisplay = document.querySelector(SELECTORS.markupDisplay);
                const marginDisplay = document.querySelector(SELECTORS.marginDisplay);
                const overheadDisplay = document.querySelector(SELECTORS.overheadDisplay);
                const markupMarginToggle = document.querySelector(SELECTORS.markupMarginToggle);
                const overheadCostToggle = document.querySelector(SELECTORS.overheadCostToggle);

                const purchasePrice = UIManager.parseCurrency(purchasePriceInput.value);
                const sellingPrice = UIManager.parseCurrency(sellingPriceInput.value);
                const overheadPercentage = overheadDisplay ?
                    UIManager.parsePercentage(overheadDisplay.value) : 0;

                let calculatedSellingPrice = sellingPrice;

                // Jika toggle markup/margin dan overhead aktif, hitung ulang
                if (markupMarginToggle.checked) {
                    const markupValue = UIManager.parsePercentage(markupDisplay.value);

                    // Jika overhead aktif, gunakan perhitungan dengan overhead
                    if (overheadCostToggle.checked) {
                        calculatedSellingPrice = PriceCalculator.calculateSellingPriceWithOverhead(
                            purchasePrice,
                            markupValue,
                            overheadPercentage
                        );
                        sellingPriceInput.value = UIManager.formatCurrency(calculatedSellingPrice);
                    }

                    // Hitung ulang markup dan margin
                    const markup = PriceCalculator.calculateMarkup(purchasePrice,
                        calculatedSellingPrice);
                    const margin = PriceCalculator.calculateMargin(purchasePrice,
                        calculatedSellingPrice);

                    // Update display
                    markupDisplay.value = UIManager.formatPercentage(markup);
                    marginDisplay.value = UIManager.formatPercentage(margin);
                }
            },

            handleMarkupChange: function() {
                const purchasePriceInput = document.querySelector(SELECTORS.purchasePrice);
                const sellingPriceInput = document.querySelector(SELECTORS.sellingPrice);
                const markupDisplay = document.querySelector(SELECTORS.markupDisplay);
                const marginDisplay = document.querySelector(SELECTORS.marginDisplay);

                const purchasePrice = UIManager.parseCurrency(purchasePriceInput.value);
                const markupValue = UIManager.parsePercentage(markupDisplay.value);

                if (purchasePrice > 0) {
                    // Calculate selling price based on purchase price and markup
                    const sellingPrice = PriceCalculator.calculateSellingPriceByMarkup(purchasePrice,
                        markupValue);

                    // Update selling price
                    sellingPriceInput.value = UIManager.formatCurrency(sellingPrice);

                    // Calculate and update margin
                    const margin = PriceCalculator.calculateMargin(purchasePrice, sellingPrice);
                    marginDisplay.value = UIManager.formatPercentage(margin);
                }
            },

            handleMarginChange: function() {
                const purchasePriceInput = document.querySelector(SELECTORS.purchasePrice);
                const sellingPriceInput = document.querySelector(SELECTORS.sellingPrice);
                const markupDisplay = document.querySelector(SELECTORS.markupDisplay);
                const marginDisplay = document.querySelector(SELECTORS.marginDisplay);

                const purchasePrice = UIManager.parseCurrency(purchasePriceInput.value);
                const marginValue = UIManager.parsePercentage(marginDisplay.value);

                if (purchasePrice > 0) {
                    // Calculate selling price based on purchase price and margin
                    const sellingPrice = PriceCalculator.calculateSellingPriceByMargin(purchasePrice,
                        marginValue);

                    // Update selling price
                    sellingPriceInput.value = UIManager.formatCurrency(sellingPrice);

                    // Calculate and update markup
                    const markup = PriceCalculator.calculateMarkup(purchasePrice, sellingPrice);
                    markupDisplay.value = UIManager.formatPercentage(markup);
                }
            },
        };

        // Tab Management Module
        const TabManager = {
            init: function() {
                const tabs = document.querySelectorAll(SELECTORS.tabButtons);
                const tabContents = {
                    info: document.getElementById('info'),
                    price: document.getElementById('price')
                };

                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        const tabId = tab.dataset.tab;
                        this.switchTab(tabs, tabContents, tabId);
                    });
                });
            },

            switchTab: function(tabs, tabContents, tabId) {
                tabs.forEach(tab => {
                    const isSelected = tab.dataset.tab === tabId;
                    tab.classList.toggle('text-blue-600', isSelected);
                    tab.classList.toggle('border-blue-600', isSelected);
                    tab.setAttribute('aria-selected', isSelected);
                });

                Object.entries(tabContents).forEach(([id, content]) => {
                    content.classList.toggle('hidden', id !== tabId);
                    content.classList.toggle('block', id === tabId);
                });
            }
        };

        // Event Listeners and Initialization
        function initEventListeners() {
            const markupMarginToggle = document.querySelector(SELECTORS.markupMarginToggle);
            const overheadCostToggle = document.querySelector(SELECTORS.overheadCostToggle);
            const purchasePriceInput = document.querySelector(SELECTORS.purchasePrice);
            const sellingPriceInput = document.querySelector(SELECTORS.sellingPrice);
            const markupDisplay = document.querySelector(SELECTORS.markupDisplay);
            const marginDisplay = document.querySelector(SELECTORS.marginDisplay);
            const overheadDisplay = document.querySelector(SELECTORS.overheadDisplay);
            const numericInputs = [
                purchasePriceInput,
                sellingPriceInput,
            ];
            const percentageInputs = [
                markupDisplay,
                marginDisplay,
                // overheadDisplay
            ];

            // Attach text
            numericInputs.forEach(input => {
                UIManager.attachCurrencyFormatting(input);
            });
            percentageInputs.forEach(input => {
                UIManager.attachPercentageFormatting(input);
            });

            // Toggle Markup Margin Fields
            markupMarginToggle.addEventListener('change', function() {
                UIManager.toggleMarkupMarginFields(this.checked);

                if (this.checked) {
                    PriceHandler.updatePriceCalculations();
                }
            });

            // Toggle Overhead Cost Fields
            overheadCostToggle.addEventListener('change', function() {
                UIManager.toggleOverheadCostFields(this.checked);

                if (this.checked) {
                    PriceHandler.updatePriceCalculations();
                }
            });

            // Price Change Listeners
            purchasePriceInput.addEventListener('input', () => {
                if (markupMarginToggle.checked) {
                    PriceHandler.updatePriceCalculations();
                }
            });

            sellingPriceInput.addEventListener('input', () => {
                if (markupMarginToggle.checked) {
                    PriceHandler.updatePriceCalculations();
                }
            });

            // Markup and Margin Change Listeners
            markupDisplay.addEventListener('input', PriceHandler.handleMarkupChange);
            marginDisplay.addEventListener('input', PriceHandler.handleMarginChange);

            // Overhead Cost Change Listeners
            if (overheadDisplay) {
                overheadDisplay.addEventListener('input', () => {
                    const markupMarginToggle = document.querySelector(SELECTORS.markupMarginToggle);
                    const overheadCostToggle = document.querySelector(SELECTORS.overheadCostToggle);

                    if (markupMarginToggle.checked && overheadCostToggle.checked) {
                        PriceHandler.updatePriceCalculations();
                    }
                });
            }
        }

        // Form Submission Handling
        document.querySelector(SELECTORS.createProductForm).addEventListener('submit', function(event) {
            // Pastikan semua input numerik dikonversi dengan benar
            const numericInputs = [
                SELECTORS.purchasePrice,
                SELECTORS.sellingPrice,
                SELECTORS.markupDisplay,
                SELECTORS.marginDisplay
            ];

            numericInputs.forEach(selector => {
                const input = document.querySelector(selector);
                if (input) {
                    input.value = UIManager.parseFormattedNumber(input.value);
                }
            });
        });

        // Initialization
        function init() {
            TabManager.init();
            initEventListeners();
        }

        // Start the application
        init();
    });
</script>
