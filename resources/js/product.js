export const SELECTORS = {
    purchasePrice: "#purchase_price",
    sellingPrice: "#selling_price",
    marginDisplay: "#margin_display",
    marginPercentage: "#margin_percentage",
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
};

// Price Calculation Module
export const PriceCalculator = {
    calculateMargin: function (purchasePrice, sellingPrice) {
        // Margin = (Selling Price - Purchase Price) / Selling Price
        return purchasePrice && sellingPrice
            ? ((sellingPrice - purchasePrice) / sellingPrice) * 100
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

        const purchasePrice = UIManager.parseCurrency(purchasePriceInput.value);
        const sellingPrice = UIManager.parseCurrency(sellingPriceInput.value);

        const margin = PriceCalculator.calculateMargin(
            purchasePrice,
            sellingPrice
        );
        marginDisplay.value = UIManager.formatPercentage(margin);
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

// Utils
export const UtilsProduct = {
    /**
     * Formats form data into the required JSON structure
     * @param {Array} formData - Array of form field objects
     * @returns {Object} - Formatted data object
     */
    formatRequestData: (formData) => {
        let data = {};

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
                data[item.name] =
                    typeof item.value === "number"
                        ? item.value
                        : UIManager.parsePercentage(item.value);
            } else if (
                item.name === "supplier_id" ||
                item.name === "largest_unit" ||
                item.name === "smallest_unit" ||
                item.name === "minimum_smallest_stock"
            ) {
                data[item.name] = parseInt(item.value);
            } else {
                // Skip additional unit fields for now
                data[item.name] = item.value;
            }
        });

        return data;
    },
};

export function initEventListeners() {
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

    // Price Change Listeners
    purchasePriceInput.addEventListener("input", () => {
        PriceHandler.updatePriceCalculations();
    });

    sellingPriceInput.addEventListener("input", () => {
        PriceHandler.updatePriceCalculations();
    });

    // Margin Change Listener
    marginDisplay.addEventListener("input", PriceHandler.handleMarginChange);
}
