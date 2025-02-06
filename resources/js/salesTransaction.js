export const salesTransactionUtils = {
    generateReadOnlyProductRow: (product) => {
        const discount =
            product.discount_type === "Percentage"
                ? product.discount + "%"
                : UIManager.formatCurrency(product.discount);

        return `
        <tr id="list_product_${
            product.id
        }" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-3 py-2">${product?.product?.name || "-"}</td>
            <td class="px-3 py-2">${product.qty || 0}</td>
            <td class="px-3 py-2">${product?.unit?.symbol || "-"}</td>
            <td class="px-3 py-2">${UIManager.formatCurrency(
                product?.price
            )}</td>
            <td class="px-3 py-2">${UIManager.formatCurrency(
                product?.tuslah
            )}</td>
            <td class="px-3 py-2">${discount}</td>
            <td class="px-3 py-2">${UIManager.formatCurrency(
                product.subtotal
            )}</td>
        </tr>`;
    },

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
                <div class="flex justify-center items-center gap-1">
                    <i class="fa-solid fa-minus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-minus-product-${
                        product.product.id
                    }"></i>
                    <input type="number" name="product_pos_total_${
                        product.product.id
                    }" id="product_pos_total_${product.product.id}"
                        required min="0.1" step="any" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Jumlah" value="${product.qty}">
                    <i class="fa-solid fa-plus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-plus-product-${
                        product.product.id
                    }"></i>
                </div>
                <!-- Hidden fields -->
                ${salesTransactionUtils.generateHiddenFields(product)}
            </td>
            ${salesTransactionUtils.generateSelectUnitCell(product)}
            ${salesTransactionUtils.generateInputCell("price", product, true)}
            ${salesTransactionUtils.generateInputCell("tuslah", product, true)}
            ${salesTransactionUtils.generateInputCell(
                "discount",
                product,
                false
            )}
            ${salesTransactionUtils.generateInputCell(
                "subtotal",
                product,
                true
            )}
            <td class="px-3 py-2 flex gap-2 items-center">
                <button
                    id="btn-delete-product-pos-${product.product.id}"
                    class="font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md"
                    data-id="${product.product.id}"
                    type="button"
                >
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
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
                class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
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
        if (type === "discount") {
            value =
                product.discount_type === "Percentage"
                    ? product.discount + "%"
                    : UIManager.formatCurrency(product.discount);
        } else if (["price", "tuslah", "subtotal"].includes(type)) {
            value = UIManager.formatCurrency(value);
        }

        const bgClass = readonly ? "bg-gray-200" : "bg-gray-50";

        return `
        <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
            <input type="text" 
                name="product_pos_${type}_${product.product.id}" 
                id="product_pos_${type}_${product.product.id}"
                class="${bgClass} border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="${type.charAt(0).toUpperCase() + type.slice(1)}"
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
