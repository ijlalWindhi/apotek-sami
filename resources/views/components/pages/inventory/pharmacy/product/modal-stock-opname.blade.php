<div id="modal-stock-opname" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Stock Opname <span id="product-name"></span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-stock-opname">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="create" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="flex gap-2 items-center justify-between mb-2">
                        <div class="w-full">
                            <label for="unit" class="block text-sm text-gray-900 dark:text-white">Unit</label>
                            <select name="unit" id="unit" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="system_stock" class="block text-sm text-gray-900 dark:text-white">Stok
                                Sistem</label>
                            <input type="text" name="system_stock" id="system_stock"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Stok sistem" required readonly>
                        </div>
                        <div class="w-full">
                            <label for="real_stock" class="block text-sm text-gray-900 dark:text-white">Stok
                                Fisik</label>
                            <input type="number" name="real_stock" id="real_stock" step="1" value="0"
                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 disabled:bg-gray-200 disabled:cursor-not-allowed"
                                placeholder="Stok fisik" required>
                        </div>
                        <div class="w-full">
                            <label for="difference" class="block text-sm text-gray-900 dark:text-white">Selisih</label>
                            <input type="text" name="difference" id="difference" value="0.00"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Selisih" required readonly>
                        </div>
                    </div>
                    <div class="p-2 border rounded-lg flex justify-between gap-2 w-full text-xs">
                        <div class="w-full" id="stock_largest">
                            <p id="name_largest_stock_label" class="font-semibold"></p>
                            <p>Stok Sistem : <span id="current_largest_stock_label">0</span></p>
                            <p>Stok Fisik : <span id="real_largest_stock_label">0</span></p>
                            <p>Selisih : <span id="difference_largest_stock_label">0</span></p>
                        </div>
                        <div class="w-full" id="stock_smallest">
                            <p id="name_smallest_stock_label" class="font-semibold"></p>
                            Stok Sistem : <span id="current_smallest_stock_label">0</span>
                            <p>Stok Fisik : <span id="real_smallest_stock_label">0</span></p>
                            <p>Selisih : <span id="difference_smallest_stock_label">0</span></p>
                        </div>
                    </div>
                    <x-button type="submit">Simpan</x-button>
            </form>
        </div>
    </div>
</div>

<script>
    /**
     * Data Fetching and Processing
     */
    const dataServiceStockOpname = {
        updateStock: (product_id) => {
            $('#modal-stock-opname form').prepend(templates.loadingModal);
            $.ajax({
                url: `/inventory/pharmacy/product/${product_id}/updateStock`,
                type: "POST",
                data: JSON.stringify({
                    qty_largest: parseFloat($('#real_largest_stock_label').text() || 0.00),
                    qty_smallest: parseFloat($('#real_smallest_stock_label').text() || 0.00),
                }),
                contentType: "application/json",
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    // Close modal
                    $('#modal-stock-opname').removeClass('flex').addClass('hidden');
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil memperbarui data",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Fetch data again
                    const params = urlManager.getParams();

                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: function() {
                    // Hide loading icon
                    $('#modal-stock-opname form .absolute').remove();
                }
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlersStockOpname = {
        updateStockLabels: (isLargestUnit, realStock, systemStock, conversionValue) => {
            const difference = systemStock - realStock;
            const formattedDifference = Math.abs(difference).toFixed(2);
            const differenceWithSign = difference > 0 ? `-${formattedDifference}` : formattedDifference;

            if (isLargestUnit) {
                // Update largest unit labels
                $('#real_largest_stock_label').text(realStock);
                $('#difference_largest_stock_label').text(differenceWithSign);

                // Calculate and update smallest unit labels
                const realSmallestStock = (realStock * conversionValue).toFixed(2);
                const systemSmallestStock = $('#current_smallest_stock_label').text();
                const smallestDifference = (systemSmallestStock - realSmallestStock).toFixed(2);

                $('#real_smallest_stock_label').text(realSmallestStock);
                $('#difference_smallest_stock_label').text(
                    smallestDifference > 0 ? `-${Math.abs(smallestDifference)}` : Math.abs(
                        smallestDifference)
                );
            } else {
                // Update smallest unit labels
                $('#real_smallest_stock_label').text(realStock);
                $('#difference_smallest_stock_label').text(differenceWithSign);

                // Calculate and update largest unit labels
                const realLargestStock = (realStock / conversionValue).toFixed(2);
                const systemLargestStock = $('#current_largest_stock_label').text();
                const largestDifference = (systemLargestStock - realLargestStock).toFixed(2);

                $('#real_largest_stock_label').text(realLargestStock);
                $('#difference_largest_stock_label').text(
                    largestDifference > 0 ? `-${Math.abs(largestDifference)}` : Math.abs(largestDifference)
                );
            }
        },

        init: () => {
            $('#modal-stock-opname form').on('submit', function(e) {
                e.preventDefault();

                let product_id = $('#product_id').val();
                dataServiceStockOpname.updateStock(product_id);
            });

            $(document).on("change", '#unit', function() {
                const selectedId = $(this).val();
                const isLargeUnit = $(this).find("option:first-child").val() === selectedId;
                const currentLargestStock = $('#current_largest_stock').val();
                const currentSmallestStock = $('#current_smallest_stock').val();
                const conversionValue = $('#conversion_value').val();

                const systemStock = isLargeUnit ? currentLargestStock : currentSmallestStock;
                $('#system_stock').val(systemStock);
                $('#real_stock').val(systemStock);
                $('#difference').val('0.00');

                // Reset labels to system values
                if (isLargeUnit) {
                    $('#real_largest_stock_label').text(currentLargestStock);
                    $('#real_smallest_stock_label').text(currentSmallestStock);
                } else {
                    $('#real_largest_stock_label').text(currentLargestStock);
                    $('#real_smallest_stock_label').text(currentSmallestStock);
                }
                $('#difference_largest_stock_label').text('0.00');
                $('#difference_smallest_stock_label').text('0.00');
            });

            $('#real_stock').on('input', function() {
                const systemStock = parseFloat($('#system_stock').val());
                const realStock = parseFloat($(this).val()) || 0;
                const difference = systemStock - realStock;
                const formattedDifference = Math.abs(difference).toFixed(2);
                const selectedUnit = $('#unit');
                const isLargestUnit = selectedUnit.find("option:first-child").val() === selectedUnit
                    .val();
                const conversionValue = parseFloat($('#conversion_value').val());

                // Update difference field
                $('#difference').val(difference > 0 ? `-${formattedDifference}` : formattedDifference);

                // Update all labels
                eventHandlersStockOpname.updateStockLabels(isLargestUnit, realStock, systemStock,
                    conversionValue);
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersStockOpname.init();
    });
</script>
