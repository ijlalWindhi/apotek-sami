export const productRecipeCalculations = {
    init: () => {
        // Handle plus button clicks
        $(document).on("click", '[id^="btn-plus-product-"]', function () {
            const productId = this.id.split("btn-plus-product-")[1];
            const inputElement = $(`#product_recipe_total_${productId}`);
            inputElement.val((parseInt(inputElement.val()) || 0) + 1);
            productRecipeCalculations.calculateSubtotal(productId);
        });

        // Handle minus button clicks
        $(document).on("click", '[id^="btn-minus-product-"]', function () {
            const productId = this.id.split("btn-minus-product-")[1];
            const inputElement = $(`#product_recipe_total_${productId}`);
            const currentValue = parseInt(inputElement.val()) || 0;
            if (currentValue > 0) {
                inputElement.val(currentValue - 1);
                productRecipeCalculations.calculateSubtotal(productId);
            }
        });

        // Handle manual quantity input
        $(document).on("input", '[id^="product_recipe_total_"]', function () {
            const productId = this.id.split("product_recipe_total_")[1];
            productRecipeCalculations.calculateSubtotal(productId);
        });

        // Handle discount changes
        $(document).on(
            "input",
            '[id^="product_recipe_discount_"]',
            function () {
                const productId = this.id.split("product_recipe_discount_")[1];
                productRecipeCalculations.calculateSubtotal(productId);
            }
        );

        // Handle delete button clicks
        $(document).on("click", '[id^="btn-delete-product-"]', function () {
            const productId = this.id.split("btn-delete-product-")[1];

            // Remove the entire row
            $(`tr:has(#btn-delete-product-${productId})`).remove();

            // Trigger custom event for total calculations
            $(document).trigger("subtotalUpdated");

            // Check if table is empty and show empty state if needed
            if ($("#table-body tr").length === 0) {
                $("#table-body").html(`
                    <tr>
                        <td id="label_empty_data" colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada produk yang dipilih
                        </td>
                    </tr>
                `);
            }
        });

        // Handle unit changes
        $(document).on("change", '[id^="product_recipe_unit_"]', function () {
            const productId = this.id.split("product_recipe_unit_")[1];
            const unitId = $(this).val();
            const unitName = $(this).find("option:selected").text();
            const conversionValue =
                parseInt($(`#product_recipe_conversion_${productId}`).val()) ||
                1;

            // Get the selected option's parent select element
            const selectElement = $(this);
            const isLargestUnit =
                selectElement.find("option:first-child").val() === unitId;

            // Get current price input element
            const priceInput = $(`#product_recipe_price_${productId}`);

            // Get or store original price
            let originalPrice;
            if (!priceInput.data("original-price")) {
                // If original price is not stored yet, store current price
                originalPrice =
                    parseInt(priceInput.val()?.replace(/[^\d]/g, "")) || 0;
                priceInput.data("original-price", originalPrice);
            } else {
                // Get stored original price
                originalPrice = priceInput.data("original-price");
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
            productRecipeCalculations.calculateSubtotal(productId);
        });

        // Handle tuslah changes
        $(document).on("input", '[id^="product_recipe_tuslah_"]', function () {
            const productId = this.id.split("product_recipe_tuslah_")[1];
            const rawValue = $(this).val().replace(/[^\d]/g, "");
            $(this).val(UIManager.formatCurrency(rawValue));
            productRecipeCalculations.calculateSubtotal(productId);
        });
    },

    calculateSubtotal: (productId) => {
        const quantity =
            parseInt($(`#product_recipe_total_${productId}`).val()) || 0;
        const price =
            parseInt(
                $(`#product_recipe_price_${productId}`)
                    .val()
                    ?.replace(/[^\d]/g, "")
            ) || 0;
        const tuslah =
            parseInt(
                $(`#product_recipe_tuslah_${productId}`)
                    .val()
                    ?.replace(/[^\d]/g, "")
            ) || 0;
        const discountInput = $(`#product_recipe_discount_${productId}`).val();

        let subtotal = quantity * price;
        subtotal += quantity * tuslah;

        // Handle discount calculation
        if (discountInput) {
            // Check if discount is a percentage (ends with %)
            if (discountInput.endsWith("%")) {
                const discountPercentage = parseFloat(discountInput) || 0;
                subtotal = subtotal * (1 - discountPercentage / 100);
            } else {
                // Assume it's a fixed amount
                const discountAmount =
                    parseInt(discountInput?.replace(/[^\d]/g, "")) || 0;
                subtotal = subtotal - discountAmount;
            }
        }

        // Ensure subtotal is not negative
        subtotal = Math.max(0, subtotal);

        // Update subtotal field with formatted currency
        $(`#product_recipe_subtotal_${productId}`).val(
            UIManager.formatCurrency(subtotal)
        );

        // Update price field with formatted currency
        $(`#product_recipe_price_${productId}`).val(
            UIManager.formatCurrency(price)
        );

        // Trigger custom event for total calculations
        $(document).trigger("subtotalUpdated");
    },
};
