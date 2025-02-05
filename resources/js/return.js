export const returnUtils = {
    generateEditableProductRow: (product) => {
        return `
        <tr id="list_product_pos_${
            product.product.id
        }" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white" id="product_pos_name_${
                product.product.id
            }">
                ${utils.escapeHtml(product.product.name || "-")}
            </td>
            <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                <input type="number" name="product_pos_total_${
                    product.product.id
                }" id="product_pos_total_${product.product.id}"
                    required min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Jumlah" value="${product.qty}" readonly>
                <!-- Hidden fields -->
                ${returnUtils.generateHiddenFields(product)}
            </td>
            ${returnUtils.generateSelectUnitCell(product)}
            ${returnUtils.generateInputCell("price", product, true)}
            ${returnUtils.generateInputCell("tuslah", product, true)}
            ${returnUtils.generateInputCell("discount", product, true)}
            ${returnUtils.generateInputCell("subtotal", product, true)}
            ${returnUtils.generateInputCell("qty_return", product, false)}
            ${returnUtils.generateSelectUnitCell(product)}
            ${returnUtils.generateInputCell("subtotal_return", product, true)}
        </tr>`;
    },

    // Helper functions for generating cell contents
    generateHiddenFields: (product) => {
        return `
        <input type="hidden" name="product_pos_id_${product.product.id}" id="product_pos_id_${product.product.id}"
            value="${product.product.id}">
        <input type="hidden" name="product_pos_smallest_stock_${product.product.id}" id="product_pos_smallest_stock_${product.product.id}"
            value="${product.product.smallest_stock}">
        <input type="hidden" name="product_pos_largest_stock_${product.product.id}" id="product_pos_largest_stock_${product.product.id}"
            value="${product.product.largest_stock}">
        <input type="hidden" name="product_pos_sales_transaction_id_${product.product.id}" id="product_pos_sales_transaction_id_${product.product.id}"
            value="${product.id}">
    `;
    },

    generateSelectUnitCell: (product) => {
        return `
        <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
            <select name="product_pos_unit_${
                product.product.id
            }" id="product_pos_unit_${product.product.id}"
                class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" disabled>
                <option value="${product.product.largest_unit.id}" ${
            product.product.largest_unit.id === product.unit?.id
                ? "selected"
                : ""
        }>${product.product.largest_unit.symbol}</option>
                <option value="${product.product.smallest_unit.id}" ${
            product.product.smallest_unit.id === product.unit?.id
                ? "selected"
                : ""
        }>${product.product.smallest_unit.symbol}</option>
            </select>
            <input type="hidden" name="product_pos_conversion_${
                product.product.id
            }" id="product_pos_conversion_${product.product.id}"
                value="${product.product.conversion_value}">
        </td>
    `;
    },

    generateInputCell: (type, product, readonly = false) => {
        let value = product[type];
        let placeholder = type.charAt(0).toUpperCase() + type.slice(1);
        if (type === "discount") {
            value =
                product.discount_type === "Percentage"
                    ? product.discount + "%"
                    : UIManager.formatCurrency(product.discount);
        } else if (["price", "tuslah", "subtotal"].includes(type)) {
            value = UIManager.formatCurrency(value);
        } else if (["qty_return", "subtotal_return"].includes(type)) {
            value = 0;
            placeholder = placeholder.replace("_", " ");
        }

        const bgClass = readonly ? "bg-gray-200" : "bg-gray-50";

        return `
        <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
            <input type="text" 
                name="product_pos_${type}_${product.product.id}" 
                id="product_pos_${type}_${product.product.id}"
                class="${bgClass} border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="${placeholder}"
                value="${value}"
                ${readonly ? "readonly" : ""}
                required>
            ${
                type === "price"
                    ? `
                <input type="hidden" 
                    name="product_pos_selling_price_${product.product.id}" 
                    id="product_pos_selling_price_${product.product.id}"
                    value="${product.product.selling_price}">
            `
                    : ""
            }
        </td>
    `;
    },
};

export const priceCalculationsReturn = {
    init() {
        this.setupEventListeners();
        this.updateTotals();
    },

    setupEventListeners() {
        // Listen for changes in qty_return inputs
        $("body").on("input", 'input[id^="product_pos_qty_return_"]', (e) => {
            const productId = e.target.id.split("_").pop();
            const qtyReturn = parseFloat(e.target.value) || 0;
            const originalQty = parseFloat(
                $(`#product_pos_total_${productId}`).val()
            );

            if (qtyReturn > originalQty) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Qty return cannot be greater than original qty!",
                });
                e.target.value = originalQty;
                return;
            }
            this.calculateSubtotalReturn(productId);
            this.updateTotals();
        });
    },

    calculateSubtotalReturn(productId) {
        // Get all required values
        const qtyReturn =
            parseFloat($(`#product_pos_qty_return_${productId}`).val()) || 0;
        const originalQty = parseFloat(
            $(`#product_pos_total_${productId}`).val()
        );
        const basePrice = this.extractNumericValue(
            $(`#product_pos_price_${productId}`).val()
        );
        const tuslah = this.extractNumericValue(
            $(`#product_pos_tuslah_${productId}`).val()
        );
        const discount = this.extractDiscountValue(
            $(`#product_pos_discount_${productId}`).val()
        );

        // Calculate unit price including tuslah
        const unitPriceWithTuslah = basePrice + tuslah / originalQty;

        // Calculate discount per unit
        const discountPerUnit = discount / originalQty;

        // Calculate subtotal return
        const subtotalReturn =
            qtyReturn * (unitPriceWithTuslah - discountPerUnit);

        // Update subtotal return field
        $(`#product_pos_subtotal_return_${productId}`).val(
            UIManager.formatCurrency(subtotalReturn)
        );
    },

    updateTotals() {
        let totalQtyReturn = 0;
        let totalBeforeDiscount = 0;

        // Calculate totals from all products
        $('input[id^="product_pos_qty_return_"]').each((index, element) => {
            const productId = element.id.split("_").pop();

            // Sum up quantities
            const qtyReturn = parseFloat($(element).val()) || 0;
            totalQtyReturn += qtyReturn;

            // Sum up subtotals
            const subtotalReturn = this.extractNumericValue(
                $(`#product_pos_subtotal_return_${productId}`).val()
            );
            totalBeforeDiscount += subtotalReturn;
        });

        // Update total qty return
        $("#qty_total_return").val(totalQtyReturn);

        // Update total before discount
        $("#total_before_discount").val(
            UIManager.formatCurrency(totalBeforeDiscount)
        );

        // Calculate and update final total (rounded up to nearest 100)
        const roundedTotal = this.roundUpToNearest100(totalBeforeDiscount);
        $("#total").val(UIManager.formatCurrency(roundedTotal));
    },

    // Helper function to extract numeric value from currency string
    extractNumericValue(value) {
        if (typeof value === "number") return value;
        return parseFloat(value?.replace(/[^\d]/g, "")) || 0;
    },

    // Helper function to extract discount value (handles both percentage and fixed amounts)
    extractDiscountValue(value) {
        if (!value) return 0;

        // Check if it's a percentage discount
        if (value.includes("%")) {
            const percentage = parseFloat(value) || 0;
            const basePrice = this.extractNumericValue(
                $(`#product_pos_price_${productId}`).val()
            );
            return (percentage / 100) * basePrice;
        }

        // Otherwise treat as fixed amount
        return this.extractNumericValue(value);
    },

    // Helper function to round up to nearest 100
    roundUpToNearest100(value) {
        return Math.ceil(value / 100) * 100;
    },
};
