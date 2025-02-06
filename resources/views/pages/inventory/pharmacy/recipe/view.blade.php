<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form id="view-recipe" class="flex flex-col gap-4 justify-between w-full h-full p-4">
        @csrf
        <div class="grid grid-cols-2 gap-2 items-center justify-between">
            <div class="col-span-2 md:col-span-1 p-2 border rounded-md shadow-sm">
                <h2 class="font-semibold text-sm mb-1.5">Informasi</h2>
                <div class="flex gap-2 w-full items-end">
                    <div class="w-full">
                        <label for="name" class="block text-xs  text-gray-900 dark:text-white">Nama
                            Resep <span class="text-red-500">*</span></label>
                        <input name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nama resep" required>
                    </div>
                    <div class="w-full select-small">
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
            <div class="col-span-2 md:col-span-1 p-2 border rounded-md shadow-sm">
                <h2 class="font-semibold text-sm mb-1.5">Dokter</h2>
                <div class="flex gap-2 w-full items-end">
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
            <div class="col-span-2 p-2 border rounded-md shadow-sm">
                <h2 class="font-semibold text-sm mb-1.5">Pelanggan</h2>
                <div class="flex gap-2 w-full items-end">
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
                        <input type="number" name="customer_age" id="customer_age" min="1" step="1"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Usia pelanggan" required>
                    </div>
                    <div class="w-full">
                        <label for="customer_address"
                            class="block text-xs  text-gray-900 dark:text-white">Alamat</label>
                        <input type="text" name="customer_address" id="customer_address"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Alamat pelanggan">
                    </div>
                </div>
            </div>
        </div>

        {{-- List Item --}}
        <div class="flex flex-col gap-3">
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
                        <tr>
                            <td id="label_empty_data" colspan="8"
                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada produk yang dipilih
                            </td>
                        </tr>
                        {{-- Table content will be inserted here --}}
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end items-center gap-3 flex-col sm:flex-row">
            <a href="{{ route('return.list') }}" class="w-full md:w-32">
                <x-button color="blue" class="w-full md:w-32">Kembali</x-button>
            </a>
            <x-button type="submit" color="green" class="w-full md:w-32" id="btn-update-recipe">Simpan</x-button>
        </div>
    </form>
    <x-pages.pos.modal-add-product></x-pages.pos.modal-add-product>
</x-layout>

<script>
    /**
     * Detail Recipe Module
     * Handles the detail Recipe page
     */
    const url = window.location.pathname;
    const recipeId = url.split('/').pop();
    let resData = {};
    const PER_PAGE = 999999;
    const DEBOUNCE_DELAY = 500;
    const TEXT_TRUNCATE_LENGTH = 40;

    function formattedData(formData) {
        // Convert formData array to object
        const formDataObj = {};
        formData.forEach(item => {
            formDataObj[item.name] = item.value;
        });

        // Initialize products array
        const products = [];
        const productRows = $('#table-body tr').not(':has(td[colspan])');

        // Process each product row
        productRows.each(function() {
            const row = $(this);
            const productId = row.find('input[id^="product_recipe_id_"]').val();
            const productRecipeId = row.find('input[id^="id_recipe_product_"]')
                .val(); // Ambil ID dari m_product_recipe

            if (productId) {
                const qty = parseInt(row.find(`input[id^="product_recipe_total_${productId}"]`).val()) || 0;
                const price = parseInt(row.find(`input[id^="product_recipe_price_${productId}"]`).val()
                    ?.replace(/[^\d]/g, '')) || 0;
                const tuslah = parseInt(row.find(`input[id^="product_recipe_tuslah_${productId}"]`).val()
                    ?.replace(/[^\d]/g, '')) || 0;
                const discountInput = row.find(`input[id^="product_recipe_discount_${productId}"]`).val();
                const subtotal = parseInt(row.find(`input[id^="product_recipe_subtotal_${productId}"]`).val()
                    ?.replace(/[^\d]/g, '')) || 0;

                let discount = 0;
                let discountType = 'Nominal';

                if (discountInput) {
                    if (discountInput.endsWith('%')) {
                        discount = parseFloat(discountInput || 0);
                        discountType = 'Percentage';
                    } else {
                        discount = parseInt(discountInput?.replace(/[^\d]/g, '') || 0);
                    }
                }

                products.push({
                    id: productRecipeId,
                    product: productId,
                    qty: qty,
                    price: price,
                    tuslah: tuslah,
                    discount: discount,
                    discount_type: discountType,
                    subtotal: subtotal,
                    unit: row.find(`select[id^="product_recipe_unit_${productId}"]`).val(),
                });
            }
        });

        // Build the final request object
        const requestData = {
            ...formDataObj,
            products: products,
        };

        return requestData;
    }

    /**
     * Data Fetching and Processing
     */
    const dataServiceRecipe = {
        fetchData: async () => {
            $("#view-recipe").prepend(uiManager.showScreenLoader());

            try {
                const response = await $.ajax({
                    url: `/inventory/pharmacy/recipe/${recipeId}`,
                    method: 'GET',
                    contentType: 'application/json',
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                if (!response?.success) {
                    throw new Error('Invalid response format');
                }

                resData = response.data;
                const data = response.data;
                const form = $('form');

                // Set form values and handle products
                dataServiceRecipe.setFormValues(form, data);
                dataServiceRecipe.setProducts(data.products);
            } catch (error) {
                handleFetchError(error);
                uiManager.showError('Gagal mengambil data Recipe. Silahkan coba lagi.');
            } finally {
                uiManager.hideScreenLoader();
            }
        },

        updateRecipe: (data) => {
            $("#view-recipe").prepend(uiManager.showScreenLoader());

            $.ajax({
                url: `/inventory/pharmacy/recipe/${recipeId}`,
                method: 'PUT',
                data: JSON.stringify(data),
                contentType: 'application/json',
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil memperbarui data",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        window.location.href = '/inventory/pharmacy/recipe';
                    }, 1500);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: () => {
                    uiManager.hideScreenLoader();
                }
            });
        },

        setFormValues: (form, data) => {
            // Separate regular form fields and display-only fields
            const formFields = {
                name: data?.name,
                staff_id: data?.staff?.id,
                doctor_name: data?.doctor_name,
                doctor_sip: data?.doctor_sip,
                customer_name: data?.customer_name,
                customer_age: data?.customer_age,
                customer_address: data?.customer_address,
            };

            // Set values for form fields
            Object.entries(formFields).forEach(([field, value]) => {
                const element = form.find(`[name="${field}"]`);
                element.val(value);

                // Trigger change event for select elements
                if (element.is('select')) {
                    element.trigger('change');
                }
            });
        },

        setProducts: (data) => {
            debug.log("UpdateTableListItem", "Starting table update");
            const tbody = $("#table-body");

            if (!Array.isArray(data) || data.length === 0) {
                tbody.html(table.emptyTable());
                return;
            }

            document?.getElementById("label_empty_data")?.remove();
            tbody.append(data.map((product) => templatesRecipe.tableRowProduct(product)).join(""));
            debug.log("UpdateTable", "Table updated successfully");
        },
    };

    /**
     * HTML Templates
     */
    const templatesRecipe = {
        tableRowProduct: (product) => `
            <tr id="list_product_recipe_${product?.product?.id}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${utils.escapeHtml(product?.product?.name || '-')}
                </th>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <div class="flex justify-center items-center gap-1">
                        <i class="fa-solid fa-minus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-minus-product-${product?.product?.id}"></i>
                        <input type="number" name="product_recipe_total_${product?.product?.id}" id="product_recipe_total_${product?.product?.id}"
                            required min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Jumlah" value="${product?.qty}">
                        <i class="fa-solid fa-plus p-1 bg-orange-500 text-white rounded-full cursor-pointer" id="btn-plus-product-${product?.product?.id}"></i>
                    </div>
                    <input type="hidden" name="product_recipe_id_${product?.product?.id}" id="product_recipe_id_${product?.product?.id}"
                        value="${product?.product?.id}">
                    <input type="hidden" name="id_recipe_product_${product?.id}" id="id_recipe_product_${product?.id}"
                        value="${product?.id}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <select name="product_recipe_unit_${product?.product?.id}" id="product_recipe_unit_${product?.product?.id}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="${product?.product?.largest_unit?.id}" selected>${product?.product?.largest_unit?.symbol}</option>
                        <option value="${product?.product?.smallest_unit?.id}">${product?.product?.smallest_unit?.symbol}</option>
                    </select>
                    <input type="hidden" name="product_recipe_conversion_${product?.product?.id}" id="product_recipe_conversion_${product?.product?.id}"
                        value="${product?.product?.conversion_value}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_recipe_price_${product?.product?.id}" id="product_recipe_price_${product?.product?.id}"
                        required readonly
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Harga" value="${UIManager.formatCurrency(product?.product?.selling_price)}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_recipe_tuslah_${product?.product?.id}" id="product_recipe_tuslah_${product?.product?.id}"
                        required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Tuslah" value="${UIManager.formatCurrency(product?.tuslah)}">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_recipe_discount_${product?.product?.id}" id="product_recipe_discount_${product?.product?.id}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Diskon" value="${
                            product?.discount_type === 'Nominal'
                                ? UIManager.formatCurrency(product?.discount)
                                : `${product?.discount}%`
                        }">
                </td>
                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">
                    <input type="text" name="product_recipe_subtotal_${product?.product?.id}" id="product_recipe_subtotal_${product?.product?.id}" required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-primary-600 focus:border-primary-600 block w-full px-2.5 py-1.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Sub Total" readonly value="${UIManager.formatCurrency(product?.subtotal)}">
                </td>
                <td class="px-3 py-2 flex gap-2 items-center">
                    <button
                        id="btn-delete-product-${product?.product?.id}"
                        class="font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md"
                        data-id="${product?.product?.id}"
                        type="button"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        `,
    }

    /**
     * Event Handlers
     */
    const eventHandlerRecipe = {
        init: () => {
            // Submit form for create
            $('form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serializeArray();
                const data = formattedData(formData);
                dataServiceRecipe.createRecipe(data);
            });

            // Submit form for update
            $('#btn-update-recipe').on('click', function(e) {
                e.preventDefault();
                const formData = $('form').serializeArray();
                const data = formattedData(formData);
                dataServiceRecipe.updateRecipe(data);
            });
        },
    };

    /**
     * Initialize the detail Recipe page
     */
    function initTransactionDetail() {
        debug.log('Init', 'Initializing Recipe detail...');

        dataServiceRecipe.fetchData();
    }

    $(document).ready(function() {
        debug.log('Ready', 'Document ready, initializing...');
        initTransactionDetail();
        eventHandlerRecipe.init();
        productRecipeCalculations.init();

        // Initialize select2
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownAutoWidth: true,
        });
    });
</script>
