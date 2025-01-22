export const priceCalculationsPO = {
    init: () => {
        // Listen for changes in product subtotals
        $(document).on("subtotalUpdated", priceCalculationsPO.updateAllTotals);

        // Handle main discount input changes
        $("#discount").on("input", function () {
            priceCalculationsPO.updateAllTotals();
        });
    },

    updateAllTotals: () => {
        const isIncludeTax = $("#payment_include_tax").val();
        const totals = priceCalculationsPO.calculateProductTotals(isIncludeTax);

        // Update quantity total
        $("#qty_total").val(totals.quantityTotal);

        // Update total before tax and discount
        $("#total_before_tax_discount").val(
            UIManager.formatCurrency(totals.totalBeforeTaxDiscount)
        );

        // Calculate discount
        const discount = priceCalculationsPO.calculateMainDiscount(
            totals.totalBeforeTaxDiscount
        );
        $("#nominal_discount").val(
            UIManager.formatCurrency(discount.nominalDiscount)
        );

        // Update total discount
        $("#discount_total").val(
            UIManager.formatCurrency(discount.nominalDiscount)
        );

        // Calculate tax
        const totalAfterDiscount =
            totals.totalBeforeTaxDiscount - discount.nominalDiscount;
        const tax = priceCalculationsPO.calculateTax(
            totalAfterDiscount,
            isIncludeTax
        );
        $("#tax_total").val(UIManager.formatCurrency(tax));

        // Calculate final total
        let finalTotal;
        if (isIncludeTax === "1") {
            // If price includes tax, we add back the tax component
            finalTotal = totalAfterDiscount + tax;
        } else {
            // If price excludes tax, we add the calculated tax
            finalTotal = totalAfterDiscount + tax;
        }
        $("#total").val(UIManager.formatCurrency(finalTotal));
    },

    calculateProductTotals: (isIncludeTax) => {
        let quantityTotal = 0;
        let totalBeforeTaxDiscount = 0;

        // Iterate through all product rows
        $("#table-body tr")
            .not(":has(td[colspan])")
            .each(function () {
                const quantity =
                    parseInt(
                        $(this).find('input[id^="product_total_"]').val()
                    ) || 0;
                const price =
                    parseInt(
                        $(this)
                            .find('input[id^="product_price_"]')
                            .val()
                            ?.replace(/[^\d]/g, "")
                    ) || 0;
                const subtotal =
                    parseInt(
                        $(this)
                            .find('input[id^="product_subtotal_"]')
                            .val()
                            ?.replace(/[^\d]/g, "")
                    ) || 0;

                quantityTotal += quantity;

                if (isIncludeTax === "1") {
                    // If price includes tax, we need to remove tax component
                    const priceBeforeTax = Math.round(
                        subtotal / (1 + taxPercentage / 100)
                    );
                    totalBeforeTaxDiscount += priceBeforeTax;
                } else {
                    // If price excludes tax, use subtotal directly
                    totalBeforeTaxDiscount += subtotal;
                }
            });

        return {
            quantityTotal,
            totalBeforeTaxDiscount,
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

    calculateTax: (totalAfterDiscount, isIncludeTax) => {
        if (!taxPercentage || totalAfterDiscount <= 0) return 0;

        if (isIncludeTax === "1") {
            // If price includes tax, calculate tax component from the total
            return Math.round(
                totalAfterDiscount * (taxPercentage / (100 + taxPercentage))
            );
        } else {
            // If price excludes tax, calculate tax as additional
            return Math.round(totalAfterDiscount * (taxPercentage / 100));
        }
    },
};
