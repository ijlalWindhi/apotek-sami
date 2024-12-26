export const SELECTORS = {
    marginToggle: "#show_margin",
    marginFields: ".margin-fields",
    purchasePrice: "#purchase_price",
    sellingPrice: "#selling_price",
    marginDisplay: "#margin_display",
    marginPercentage: "#margin_percentage",
    tabButtons: ".tab-button",
    createProductForm: "#create-product",
};

// UI Manager Module
export const UIManager = {
    // Formatting untuk input yang terkait dengan uang (harga)
    formatCurrency: function (number, options = {}) {
        const { decimalPlaces = 0, useGrouping = true } = options;

        const numValue = parseFloat(number);
        if (isNaN(numValue)) return "0";

        return numValue.toLocaleString("id-ID", {
            minimumFractionDigits: decimalPlaces,
            maximumFractionDigits: decimalPlaces,
            useGrouping: useGrouping,
        });
    },

    // Formatting untuk input persentase (mendukung desimal)
    formatPercentage: function (number, options = {}) {
        const { decimalPlaces = 2, maxValue = 100 } = options;

        const numValue = parseFloat(number);
        if (isNaN(numValue)) return "0,00";

        // Batasi nilai maksimal
        const constrainedValue = Math.min(numValue, maxValue);

        // Gunakan toFixed untuk presisi desimal, kemudian ganti titik dengan koma
        return constrainedValue.toFixed(decimalPlaces).replace(".", ",");
    },

    // Parse input mata uang
    parseCurrency: function (formattedValue) {
        if (typeof formattedValue !== "string") return 0;
        // Remove thousand separators and replace comma with dot
        const cleanedValue = formattedValue
            .replace(/\./g, "")
            .replace(",", ".");
        const parsedValue = parseFloat(cleanedValue);
        return isNaN(parsedValue) ? 0 : parsedValue;
    },

    // Parse input persentase
    parsePercentage: function (formattedValue) {
        if (typeof formattedValue !== "string") return 0;

        // Normalisasi input - ganti koma dengan titik untuk parsing
        const cleanedValue = formattedValue.replace(",", ".");

        const parsedValue = parseFloat(cleanedValue);
        return isNaN(parsedValue) ? 0 : parsedValue;
    },

    // Attach formatting untuk input mata uang
    attachCurrencyFormatting: function (inputElement, options = {}) {
        const { decimalPlaces = 0 } = options;

        inputElement.type = "text";
        inputElement.value = "0";

        inputElement.addEventListener("input", (event) => {
            const cursorPosition = event.target.selectionStart;

            // Bersihkan input dari karakter non-numerik
            let value = event.target.value.replace(/[^0-9]/g, "");

            const formattedValue = this.formatCurrency(value, {
                decimalPlaces: decimalPlaces,
                useGrouping: true,
            });

            event.target.value = formattedValue;

            const newValue = event.target.value;
            const addedDots = (newValue.match(/\./g) || []).length;
            const newCursorPosition = Math.max(cursorPosition + addedDots, 0);
            event.target.setSelectionRange(
                newCursorPosition,
                newCursorPosition
            );
        });

        inputElement.addEventListener("focus", (event) => {
            if (event.target.value === "0") {
                event.target.value = "";
            }
        });

        inputElement.addEventListener("blur", (event) => {
            if (event.target.value.trim() === "") {
                event.target.value = "0";
            } else {
                event.target.value = this.formatCurrency(
                    this.parseCurrency(event.target.value),
                    {
                        decimalPlaces: decimalPlaces,
                        useGrouping: true,
                    }
                );
            }
        });
    },

    // Attach formatting untuk input persentase
    attachPercentageFormatting: function (inputElement, options = {}) {
        const {
            decimalPlaces = 2,
            maxValue = 100, // Batasi maksimal 100%
        } = options;

        inputElement.type = "text";
        inputElement.value = "0,00"; // Gunakan koma untuk desimal Indonesia

        inputElement.addEventListener("input", (event) => {
            // Izinkan input numerik, koma, dan titik
            let value = event.target.value.replace(/[^0-9,\.]/g, "");

            // Normalisasi desimal - ganti titik atau koma ke format Indonesia
            value = value.replace(".", ",");

            // Batasi jumlah koma
            const commaCount = (value.match(/,/g) || []).length;
            if (commaCount > 1) {
                // Hapus koma tambahan
                value = value
                    .replace(/,/g, "")
                    .replace(/(\d+)(\d{2})$/, "$1,$2");
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
                event.target.value = "100,00";
            }
        });

        inputElement.addEventListener("focus", (event) => {
            // Hapus '0,00' saat difokus
            if (event.target.value === "0,00") {
                event.target.value = "";
            }
        });

        inputElement.addEventListener("blur", (event) => {
            let value = event.target.value.trim();

            // Kembalikan ke '0,00' jika kosong
            if (value === "" || value === ",") {
                event.target.value = "0,00";
                return;
            }

            // Pastikan ada digit desimal
            if (!value.includes(",")) {
                value += ",00";
            }

            // Tambahkan nol di belakang koma jika kurang dari 2 digit
            const parts = value.split(",");
            if (parts[1].length === 1) {
                value += "0";
            }

            // Format dan batasi maksimal 100%
            const parsedValue = this.parsePercentage(value);
            const formattedValue = this.formatPercentage(
                Math.min(parsedValue, 100),
                {
                    decimalPlaces: decimalPlaces,
                }
            );

            event.target.value = formattedValue;
        });
    },

    toggleMarginFields: function (isChecked) {
        const fields = document.querySelectorAll(SELECTORS.marginFields);
        fields.forEach((field) => field.classList.toggle("hidden", !isChecked));
    },
};

// Price Calculation Module
export const PriceCalculator = {
    calculateMargin: function (purchasePrice, sellingPrice) {
        // Margin = (Selling Price - Purchase Price) / Selling Price
        return purchasePrice && sellingPrice
            ? (sellingPrice - purchasePrice) / sellingPrice
            : 0;
    },

    calculateSellingPriceByMargin: function (purchasePrice, marginPercentage) {
        // Selling Price = Purchase Price / (1 - Margin%)
        return purchasePrice / (1 - marginPercentage / 100);
    },
};

// Price Handling Module
export const PriceHandler = {
    updatePriceCalculations: function () {
        const purchasePriceInput = document.querySelector(
            SELECTORS.purchasePrice
        );
        const sellingPriceInput = document.querySelector(
            SELECTORS.sellingPrice
        );
        const marginDisplay = document.querySelector(SELECTORS.marginDisplay);
        const marginToggle = document.querySelector(SELECTORS.marginToggle);

        const purchasePrice = UIManager.parseCurrency(purchasePriceInput.value);
        const sellingPrice = UIManager.parseCurrency(sellingPriceInput.value);

        if (marginToggle.checked) {
            // Calculate and update margin
            const margin = PriceCalculator.calculateMargin(
                purchasePrice,
                sellingPrice
            );
            marginDisplay.value = UIManager.formatPercentage(margin);
        }
    },

    handleMarginChange: function () {
        const purchasePriceInput = document.querySelector(
            SELECTORS.purchasePrice
        );
        const sellingPriceInput = document.querySelector(
            SELECTORS.sellingPrice
        );
        const marginDisplay = document.querySelector(SELECTORS.marginDisplay);

        const purchasePrice = UIManager.parseCurrency(purchasePriceInput.value);
        const marginValue = UIManager.parsePercentage(marginDisplay.value);

        if (purchasePrice > 0) {
            // Calculate selling price based on purchase price and margin
            const sellingPrice = PriceCalculator.calculateSellingPriceByMargin(
                purchasePrice,
                marginValue
            );

            // Update selling price
            sellingPriceInput.value = UIManager.formatCurrency(sellingPrice);
        }
    },
};

// Tab Management Module
export const TabManager = {
    init: function () {
        const tabs = document.querySelectorAll(".tab-button");
        const tabContents = {
            info: document.getElementById("info"),
            price: document.getElementById("price"),
        };

        tabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                const tabId = tab.dataset.tab;
                this.switchTab(tabs, tabContents, tabId);
            });
        });
    },

    switchTab: function (tabs, tabContents, tabId) {
        tabs.forEach((tab) => {
            const isSelected = tab.dataset.tab === tabId;
            tab.classList.toggle("text-blue-600", isSelected);
            tab.classList.toggle("border-blue-600", isSelected);
            tab.setAttribute("aria-selected", isSelected);
        });

        Object.entries(tabContents).forEach(([id, content]) => {
            content.classList.toggle("hidden", id !== tabId);
            content.classList.toggle("block", id === tabId);
        });
    },
};

// Utils
export const UtilsProduct = {
    /**
     * Formats form data into the required JSON structure
     * @param {Array} formData - Array of form field objects
     * @returns {Object} - Formatted data object
     */
    formatRequestData: (formData) => {
        let data = {};
        let unitConversions = [];

        // Process basic fields first
        formData.forEach((item) => {
            if (item.name === "is_active") {
                data[item.name] = item.value === "true";
            } else if (
                item.name === "purchase_price" ||
                item.name === "selling_price"
            ) {
                data[item.name] = UIManager.parseCurrency(item.value);
            } else if (item.name === "margin_percentage") {
                data[item.name] = UIManager.parsePercentage(item.value);
            } else if (item.name === "show_margin") {
                data[item.name] = item.value === "1";
            } else if (
                item.name === "supplier" ||
                item.name === "unit" ||
                item.name === "minimum_stock"
            ) {
                data[item.name] = parseInt(item.value);
            } else if (!item.name.startsWith("additional_")) {
                // Skip additional unit fields for now
                data[item.name] = item.value;
            }
        });

        // Process unit conversions
        for (let i = 1; i <= unitCount; i++) {
            const fromValue = parseInt(
                $(`input[name="additional_conversion_${i}"]`).first().val()
            );
            const toValue = parseInt(
                $(`input[name="additional_conversion_${i}"]`).last().val()
            );
            const toUnitId = parseInt(
                $(`select[name="additional_unit_${i}"]`).val()
            );

            if (fromValue && toValue && toUnitId) {
                unitConversions.push({
                    from_unit_id: parseInt(data.unit), // Base unit ID
                    to_unit_id: toUnitId,
                    from_value: fromValue,
                    to_value: toValue,
                });
            }
        }

        if (unitConversions.length > 0) {
            data.unit_conversions = unitConversions;
        }

        return data;
    },
};

export function initEventListeners() {
    const marginToggle = document.querySelector(SELECTORS.marginToggle);
    const purchasePriceInput = document.querySelector(SELECTORS.purchasePrice);
    const sellingPriceInput = document.querySelector(SELECTORS.sellingPrice);
    const marginDisplay = document.querySelector(SELECTORS.marginDisplay);
    const numericInputs = [purchasePriceInput, sellingPriceInput];
    const percentageInputs = [marginDisplay];

    // Attach text
    numericInputs.forEach((input) => {
        UIManager.attachCurrencyFormatting(input);
    });
    percentageInputs.forEach((input) => {
        UIManager.attachPercentageFormatting(input);
    });

    // Toggle Margin Fields
    marginToggle.addEventListener("change", function () {
        UIManager.toggleMarginFields(this.checked);

        if (this.checked) {
            PriceHandler.updatePriceCalculations();
        }
    });

    // Price Change Listeners
    purchasePriceInput.addEventListener("input", () => {
        if (marginToggle.checked) {
            PriceHandler.updatePriceCalculations();
        }
    });

    sellingPriceInput.addEventListener("input", () => {
        if (marginToggle.checked) {
            PriceHandler.updatePriceCalculations();
        }
    });

    // Margin Change Listener
    marginDisplay.addEventListener("input", PriceHandler.handleMarginChange);
}
