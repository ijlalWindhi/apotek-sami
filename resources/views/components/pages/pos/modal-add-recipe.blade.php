@props(['users'])

{{-- Button Add --}}
<x-button color="blue" data-modal-target="modal-add-recipe" data-modal-toggle="modal-add-recipe" id="btn-add-customer"
    size="sm">
    <i class="fa-solid fa-plus"></i><span class="ms-1 text-xs">Tambah</span>
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
                <div class="grid grid-cols-8 gap-2 items-end">
                    <div class="col-span-8 md:col-span-3 p-2 border rounded-md shadow-sm">
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
                    <div class="col-span-8 md:col-span-3 p-2 border rounded-md shadow-sm">
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
                                <input type="number" name="customer_age" id="customer_age" min="1"
                                    step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
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
                    <div class="col-span-8 md:col-span-2 p-2 border rounded-md shadow-sm">
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
                <div class="w-full flex justify-end">
                    <x-button color="blue" size="sm" type="submit">
                        Simpan
                    </x-button>
                </div>
            </form>
        </div>
    </div>
    <x-pages.pos.modal-add-product></x-pages.pos.modal-add-product>
</div>

<script>
    /**
     * Add Recipe Modal
     * Handles all JavaScript functionalities for the Add Recipe modal
     */
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

            if (productId) {
                const qty = parseInt(row.find(`input[id^="product_recipe_total_${productId}"]`).val()) || 0;
                const price = parseInt(row.find(`input[id^="product_recipe_price_${productId}"]`).val()
                    ?.replace(
                        /[^\d]/g, '')) || 0;
                const tuslah = parseInt(row.find(`input[id^="product_recipe_tuslah_${productId}"]`).val()
                    ?.replace(
                        /[^\d]/g, '')) || 0;
                const discountInput = row.find(`input[id^="product_recipe_discount_${productId}"]`).val();
                const subtotal = parseInt(row.find(`input[id^="product_recipe_subtotal_${productId}"]`).val()
                    ?.replace(
                        /[^\d]/g, '')) || 0;

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
    const dataServiceAddRecipe = {
        createRecipe: (data) => {
            $('#modal-add-recipe form').prepend(templates.loadingModal);

            $.ajax({
                url: '/pos/recipe',
                method: 'POST',
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
                        title: "Berhasil menambahkan data",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Close modal
                    dataServiceRecipe.fetchData();
                    $('#modal-add-recipe form').trigger('reset');
                    $('#table-body').empty().html(`
                    <tr>
                        <td id="label_empty_data" colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada produk yang dipilih
                        </td>
                    </tr>`);
                    $('#modal-add-recipe form').find('.absolute').remove();
                    document.querySelector('[data-modal-target="modal-add-recipe"]').click();
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlerAddRecipe = {
        init: () => {
            // Submit form
            $('form#create').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serializeArray();
                const data = formattedData(formData);
                dataServiceAddRecipe.createRecipe(data);
            });
        },
    };

    $(document).ready(() => {
        // Initialize all modules
        productRecipeCalculations.init();
        eventHandlerAddRecipe.init();

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
