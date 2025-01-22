@props(['users'])

{{-- Button Add --}}
<x-button color="blue" data-modal-target="modal-add-recipe" data-modal-toggle="modal-add-recipe" id="btn-add-customer">
    <i class="fa-solid fa-plus"></i><span class="ms-2">Tambah</span>
</x-button>

{{-- Modal --}}
<div id="modal-add-recipe" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900/50">
    <div class="relative p-4 w-full max-w-7xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between py-1 px-5 border-b rounded-t dark:border-gray-600">
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    Tambah Resep
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-recipe">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="px-4 py-2" id="create" method="POST">
                @csrf
                <div class="grid grid-cols-7 gap-2 items-end">
                    <div class="col-span-5 md:col-span-3 p-2 border rounded-md shadow-sm">
                        <h2 class="font-semibold text-sm mb-1.5">Pelanggan</h2>
                        <div class="flex gap-2 w-full">
                            <div class="w-full">
                                <label for="customer_name" class="block text-xs  text-gray-900 dark:text-white">Nama
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="customer_name" id="customer_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nama pelanggan" required>
                            </div>
                            <div class="w-full">
                                <label for="customer_age" class="block text-xs  text-gray-900 dark:text-white">Usia
                                    <span class="text-red-500">*</span></label>
                                <input type="number" name="customer_age" id="customer_age"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Usia pelanggan" required>
                            </div>
                            <div class="w-full">
                                <label for="customer_address"
                                    class="block text-xs  text-gray-900 dark:text-white">Alamat</label>
                                <input type="text" name="customer_address" id="customer_address"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nama pelanggan">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-5 md:col-span-2 p-2 border rounded-md shadow-sm">
                        <h2 class="font-semibold text-sm mb-1.5">Dokter</h2>
                        <div class="flex gap-2 w-full">
                            <div class="w-full">
                                <label for="doctor_name" class="block text-xs  text-gray-900 dark:text-white">Nama
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="doctor_name" id="doctor_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nama dokter" required>
                            </div>
                            <div class="w-full">
                                <label for="doctor_sip" class="block text-xs  text-gray-900 dark:text-white">Nomor
                                    SIP</label>
                                <input name="doctor_sip" id="doctor_sip"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nomor SIP">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-5 md:col-span-2 flex gap-2 p-2 border rounded-md shadow-sm h-full items-end">
                        <div class="w-full">
                            <label for="status" class="block text-xs  text-gray-900 dark:text-white">Status
                                <span class="text-red-500">*</span></label>
                            <select class="js-example-basic-single" id="status" name="status">
                                <option value="Proses" selected>Proses</option>
                                <option value="Tunda">Tunda</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="staff_id" class="block text-xs  text-gray-900 dark:text-white">Karyawan
                                <span class="text-red-500">*</span></label>
                            <select class="js-example-basic-single" id="staff_id" name="staff_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3 max-h-[50vh] overflow-y-auto w-full my-2">
                    <h2 class="text-sm w-full bg-gray-100 py-1 rounded-md text-center font-semibold">Daftar Item</h2>
                    <x-button color="blue" size="sm" data-modal-target="modal-add-product"
                        data-modal-toggle="modal-add-product" class="w-full">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-2">Tambah</span>
                    </x-button>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-1 min-w-48">Nama</th>
                                    <th scope="col" class="px-3 py-1 min-w-32">Jumlah</th>
                                    <th scope="col" class="px-3 py-1 min-w-28">Satuan</th>
                                    <th scope="col" class="px-3 py-1 min-w-28">Harga</th>
                                    <th scope="col" class="px-3 py-1 min-w-28">Tuslah</th>
                                    <th scope="col" class="px-3 py-1 min-w-28">Diskon<br />(Rp / %)</th>
                                    <th scope="col" class="px-3 py-1 min-w-28">Sub Total</th>
                                    <th scope="col" class="px-3 py-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                {{-- Table content will be inserted here --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <x-button color="blue" size="sm" type="submit">
                    Simpan
                </x-button>
            </form>
        </div>
    </div>
    <x-pages.pos.modal-add-product></x-pages.pos.modal-add-product>
</div>

<script>
    // Handle form submission
    $('#modal-add-recipe form').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serializeArray();
        let data = {};

        $.each(formData, function() {
            data[this.name] = this.value;
        });

        // Show loading icon
        $('#modal-add-recipe form').prepend(uiManager.showLoadingModal);
        $.ajax({
            url: `/inventory/pharmacy/customer`,
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json",
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil menambahkan data",
                    showConfirmButton: false,
                    timer: 1500
                });

                // Close modal
                document.querySelector('[data-modal-target="modal-add-recipe"]').click();
                dataServiceCustomer.fetchData(1);
            },
            error: (xhr, status, error) => {
                handleFetchError(xhr, status, error);
            },
            complete: function() {
                // Hide loading icon
                $('#modal-add-recipe form .absolute').remove();
            }
        });
    });

    const productCalculations = {
        init: () => {
            // Handle plus button clicks
            $(document).on('click', '[id^="btn-plus-product-"]', function() {
                const productId = this.id.split('btn-plus-product-')[1];
                const inputElement = $(`#product_total_${productId}`);
                inputElement.val((parseInt(inputElement.val()) || 0) + 1);
                productCalculations.calculateSubtotal(productId);
            });

            // Handle minus button clicks
            $(document).on('click', '[id^="btn-minus-product-"]', function() {
                const productId = this.id.split('btn-minus-product-')[1];
                const inputElement = $(`#product_total_${productId}`);
                const currentValue = parseInt(inputElement.val()) || 0;
                if (currentValue > 0) {
                    inputElement.val(currentValue - 1);
                    productCalculations.calculateSubtotal(productId);
                }
            });

            // Handle manual quantity input
            $(document).on('input', '[id^="product_total_"]', function() {
                const productId = this.id.split('product_total_')[1];
                productCalculations.calculateSubtotal(productId);
            });

            // Handle discount changes
            $(document).on('input', '[id^="product_discount_"]', function() {
                const productId = this.id.split('product_discount_')[1];
                productCalculations.calculateSubtotal(productId);
            });

            // Handle delete button clicks
            $(document).on('click', '[id^="btn-delete-product-"]', function() {
                const productId = this.id.split('btn-delete-product-')[1];

                // Remove the entire row
                $(`tr:has(#btn-delete-product-${productId})`).remove();

                // Trigger custom event for total calculations
                $(document).trigger('subtotalUpdated');

                // Check if table is empty and show empty state if needed
                if ($('#table-body tr').length === 0) {
                    $('#table-body').html(`
                        <tr>
                            <td id="label_empty_data" colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada produk yang dipilih
                            </td>
                        </tr>
                    `);
                }
            });

            // Handle unit changes
            $(document).on('change', '[id^="product_unit_"]', function() {
                const productId = this.id.split('product_unit_')[1];
                const unitId = $(this).val();
                const unitName = $(this).find('option:selected').text();
                const conversionValue = parseInt($(`#product_conversion_${productId}`).val()) || 1;

                // Get the selected option's parent select element
                const selectElement = $(this);
                const isLargestUnit = selectElement.find('option:first-child').val() === unitId;

                // Get current price input element
                const priceInput = $(`#product_price_${productId}`);

                // Get or store original price
                let originalPrice;
                if (!priceInput.data('original-price')) {
                    // If original price is not stored yet, store current price
                    originalPrice = parseInt(priceInput.val()?.replace(/[^\d]/g, '')) || 0;
                    priceInput.data('original-price', originalPrice);
                } else {
                    // Get stored original price
                    originalPrice = priceInput.data('original-price');
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
                productCalculations.calculateSubtotal(productId);
            });

            // Handle tuslah changes
            $(document).on('input', '[id^="product_tuslah_"]', function() {
                const productId = this.id.split('product_tuslah_')[1];
                const rawValue = $(this).val().replace(/[^\d]/g, '');
                $(this).val(UIManager.formatCurrency(rawValue));
                productCalculations.calculateSubtotal(productId);
            });
        },

        calculateSubtotal: (productId) => {
            const quantity = parseInt($(`#product_total_${productId}`).val()) || 0;
            const price = parseInt($(`#product_price_${productId}`).val()?.replace(/[^\d]/g, '')) || 0;
            const tuslah = parseInt($(`#product_tuslah_${productId}`).val()?.replace(/[^\d]/g, '')) || 0;
            const discountInput = $(`#product_discount_${productId}`).val();

            let subtotal = quantity * price;
            subtotal += quantity * tuslah;

            // Handle discount calculation
            if (discountInput) {
                // Check if discount is a percentage (ends with %)
                if (discountInput.endsWith('%')) {
                    const discountPercentage = parseFloat(discountInput) || 0;
                    subtotal = subtotal * (1 - (discountPercentage / 100));
                } else {
                    // Assume it's a fixed amount
                    const discountAmount = parseInt(discountInput?.replace(/[^\d]/g, '')) || 0;
                    subtotal = subtotal - discountAmount;
                }
            }

            // Ensure subtotal is not negative
            subtotal = Math.max(0, subtotal);

            // Update subtotal field with formatted currency
            $(`#product_subtotal_${productId}`).val(UIManager.formatCurrency(subtotal));

            // Update price field with formatted currency
            $(`#product_price_${productId}`).val(UIManager.formatCurrency(price));

            // Trigger custom event for total calculations
            $(document).trigger('subtotalUpdated');
        }
    };

    $(document).ready(() => {
        // Initialize all modules
        productCalculations.init();

        // Add initial empty row
        $('#table-body').html(`
            <tr>
                <td id="label_empty_data" colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada produk yang dipilih
                </td>
            </tr>`);

        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    })
</script>
