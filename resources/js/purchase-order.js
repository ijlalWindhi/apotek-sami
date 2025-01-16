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
        const totals = priceCalculationsPO.calculateProductTotals();

        // Update quantity total
        $("#qty_total").val(totals.quantityTotal);

        let totalBeforeTaxDiscount = totals.totalBeforeTaxDiscount;

        // Jika harga termasuk pajak, hitung harga sebelum pajak
        if (isIncludeTax === "1") {
            totalBeforeTaxDiscount = Math.round(
                totals.totalBeforeTaxDiscount / (1 + taxPercentage / 100)
            );
        }

        // Update total before tax and discount
        $("#total_before_tax_discount").val(
            UIManager.formatCurrency(totalBeforeTaxDiscount)
        );

        // Hitung diskon
        const discount = priceCalculationsPO.calculateMainDiscount(
            totalBeforeTaxDiscount
        );
        $("#nominal_discount").val(
            UIManager.formatCurrency(discount.nominalDiscount)
        );

        // Update total discount (product discounts + main discount)
        const totalDiscount =
            totals.productDiscountsTotal + discount.nominalDiscount;
        $("#discount_total").val(UIManager.formatCurrency(totalDiscount));

        // Hitung pajak berdasarkan total setelah diskon
        const totalAfterDiscount = totalBeforeTaxDiscount - totalDiscount;
        const tax = priceCalculationsPO.calculateTax(totalAfterDiscount);
        $("#tax_total").val(UIManager.formatCurrency(tax));

        // Update final total
        let finalTotal;
        if (isIncludeTax === "1") {
            finalTotal = totals.totalBeforeTaxDiscount - totalDiscount;
        } else {
            finalTotal = totalAfterDiscount + tax;
        }
        $("#total").val(UIManager.formatCurrency(finalTotal));
    },

    calculateProductTotals: () => {
        let quantityTotal = 0;
        let totalBeforeTaxDiscount = 0;
        let productDiscountsTotal = 0;

        // Iterate through all products in the table
        $("#table-body tr").each(function () {
            const quantity =
                parseInt($(this).find('input[id^="product_total_"]').val()) ||
                0;
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
            totalBeforeTaxDiscount += quantity * price;
            productDiscountsTotal += quantity * price - subtotal;
        });

        return {
            quantityTotal,
            totalBeforeTaxDiscount,
            productDiscountsTotal,
        };
    },

    calculateMainDiscount: (total) => {
        const discountInput = $("#discount").val();
        let nominalDiscount = 0;

        if (discountInput) {
            if (discountInput.endsWith("%")) {
                // Percentage discount
                const discountPercentage = parseFloat(discountInput) || 0;
                nominalDiscount = total * (discountPercentage / 100);
            } else {
                // Fixed amount discount
                nominalDiscount =
                    parseInt(discountInput?.replace(/[^\d]/g, "")) || 0;
            }
        }

        return {
            nominalDiscount: Math.min(nominalDiscount, total), // Ensure discount doesn't exceed total
        };
    },

    calculateTax: (totalAfterDiscount) => {
        const isIncludeTax = $("#payment_include_tax").val();

        if (isIncludeTax === "1") {
            // Jika harga termasuk pajak, pajak dihitung dari total / 1.11 * 0.11
            return Math.round(totalAfterDiscount * (taxPercentage / 100));
        } else if (isIncludeTax === "0") {
            // Jika harga tidak termasuk pajak, pajak dihitung langsung
            return Math.round(totalAfterDiscount * (taxPercentage / 100));
        }

        return 0; // Default case, no tax
    },
};
