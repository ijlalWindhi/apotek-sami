export const priceCalculationsPOS = {
    init: () => {
        // Product quantity changes
        $(document).on("click", '[id^="btn-plus-product-"]', function () {
            const productId = this.id.split("btn-plus-product-")[1];
            const inputElement = $(`#product_pos_total_${productId}`);
            inputElement.val((parseInt(inputElement.val()) || 0) + 1);
            priceCalculationsPOS.calculateProductRow(productId);
        });

        $(document).on("click", '[id^="btn-minus-product-"]', function () {
            const productId = this.id.split("btn-minus-product-")[1];
            const inputElement = $(`#product_pos_total_${productId}`);
            const currentValue = parseInt(inputElement.val()) || 0;
            if (currentValue > 0) {
                inputElement.val(currentValue - 1);
                priceCalculationsPOS.calculateProductRow(productId);
            }
        });

        // Handle product discount input
        $(document).on("input", '[id^="product_pos_discount_"]', function () {
            const productId = this.id.split("product_pos_discount_")[1];
            const value = $(this).val();

            // Allow percentage symbol
            if (value.endsWith("%")) {
                const percentage = parseFloat(value) || 0;
                if (percentage > 100) $(this).val("100%");
            }

            priceCalculationsPOS.calculateProductRow(productId);
        });

        // Handle main discount input with Rp/% format
        $("#discount").on("input", function () {
            let value = $(this).val();

            // Handle percentage input
            if (value.endsWith("%")) {
                const percentage = parseFloat(value) || 0;
                if (percentage > 100) $(this).val("100%");
            } else {
                // Format as currency
                value = value.replace(/[^\d]/g, "");
                $(this).val(value);
            }

            priceCalculationsPOS.updateAllTotals();
        });

        // Handle payment input (Rp only)
        $("#customer_payment").on("input", function () {
            let value = $(this).val().replace(/[^\d]/g, "");
            $(this).val(UIManager.formatCurrency(value));
            priceCalculationsPOS.updateAllTotals();
        });

        // Delete product
        $(document).on("click", '[id^="btn-delete-product-pos-"]', function () {
            const productId = this.id.split("btn-delete-product-")[1];
            $(`tr:has(#btn-delete-product-${productId})`).remove();

            if ($("#table-body-product-pos tr").length === 0) {
                $("#table-body-product-pos").html(`
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada produk yang dipilih
                        </td>
                    </tr>
                `);
            }

            priceCalculationsPOS.updateAllTotals();
        });

        // Handle unit change
        $(document).on("change", '[id^="product_pos_unit_"]', function () {
            const productId = this.id.split("product_pos_unit_")[1];
            const unitId = $(this).val();
            const conversionValue =
                parseInt($(`#product_pos_conversion_${productId}`).val()) || 1;
            const isLargestUnit =
                $(this).find("option:first-child").val() === unitId;

            const priceInput = $(`#product_pos_price_${productId}`);
            let originalPrice = priceInput.data("original-price");

            if (!originalPrice) {
                originalPrice =
                    parseInt(priceInput.val()?.replace(/[^\d]/g, "")) || 0;
                priceInput.data("original-price", originalPrice);
            }

            const newPrice = isLargestUnit
                ? originalPrice
                : Math.floor(originalPrice / conversionValue);
            priceInput.val(UIManager.formatCurrency(newPrice));

            priceCalculationsPOS.calculateProductRow(productId);
        });
    },

    calculateAllProductRows: (products) => {
        products.forEach((product) => {
            const productId = product.product.id;
            priceCalculationsPOS.calculateProductRow(productId);
        });
        priceCalculationsPOS.updateAllTotals();
    },

    calculateProductRow: (productId) => {
        const quantity =
            parseInt($(`#product_pos_total_${productId}`).val()) || 0;
        const price =
            parseInt(
                $(`#product_pos_price_${productId}`)
                    .val()
                    ?.replace(/[^\d]/g, "")
            ) || 0;
        const tuslah =
            parseInt(
                $(`#product_pos_tuslah_${productId}`)
                    .val()
                    ?.replace(/[^\d]/g, "")
            ) || 0;
        const discountInput = $(`#product_pos_discount_${productId}`).val();

        let subtotal = quantity * price;
        subtotal += quantity * tuslah;

        if (discountInput) {
            if (discountInput.endsWith("%")) {
                const discountPercentage = parseFloat(discountInput) || 0;
                subtotal = subtotal * (1 - discountPercentage / 100);
            } else {
                const discountAmount =
                    parseInt(discountInput?.replace(/[^\d]/g, "")) || 0;
                subtotal = subtotal - discountAmount;
            }
        }

        subtotal = Math.max(0, Math.round(subtotal));
        $(`#product_pos_subtotal_${productId}`).val(
            UIManager.formatCurrency(subtotal)
        );
        $(`#product_pos_price_${productId}`).val(
            UIManager.formatCurrency(price)
        );
        $(`#product_pos_tuslah_${productId}`).val(
            UIManager.formatCurrency(tuslah)
        );

        priceCalculationsPOS.updateAllTotals();
    },

    updateAllTotals: () => {
        const totals = priceCalculationsPOS.calculateProductTotals();
        const mainDiscount = priceCalculationsPOS.calculateMainDiscount(
            totals.subtotalBeforeDiscount
        );
        const finalTotal = Math.max(
            0,
            totals.subtotalBeforeDiscount - mainDiscount.nominalDiscount
        );

        const customerPayment =
            parseInt($("#customer_payment").val()?.replace(/[^\d]/g, "")) || 0;
        const change = Math.max(0, customerPayment - finalTotal);

        $(".text-red-500 p").text(UIManager.formatCurrency(change));
        $(".text-green-500 p").text(UIManager.formatCurrency(finalTotal));
    },

    calculateProductTotals: () => {
        let subtotalBeforeDiscount = 0;

        $("#table-body-product-pos tr")
            .not(":has(td[colspan])")
            .each(function () {
                const subtotal =
                    parseInt(
                        $(this)
                            .find('input[id^="product_pos_subtotal_"]')
                            .val()
                            ?.replace(/[^\d]/g, "")
                    ) || 0;
                subtotalBeforeDiscount += subtotal;
            });

        return {
            subtotalBeforeDiscount,
        };
    },

    calculateMainDiscount: (total) => {
        const discountInput = $("#discount").val();
        let nominalDiscount = 0;

        if (discountInput) {
            if (discountInput.endsWith("%")) {
                const discountPercentage = parseFloat(discountInput) || 0;
                nominalDiscount = Math.round(
                    total * (discountPercentage / 100)
                );
            } else {
                nominalDiscount =
                    parseInt(discountInput?.replace(/[^\d]/g, "")) || 0;
            }
        }

        return {
            nominalDiscount: Math.min(nominalDiscount, total),
        };
    },
};
