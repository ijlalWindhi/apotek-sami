{{-- Button Add --}}
<x-button color="blue" data-modal-target="modal-add-customer" data-modal-toggle="modal-add-customer"
    id="btn-add-customer">
    <i class="fa-solid fa-plus"></i>
</x-button>

{{-- Modal --}}
<div id="modal-add-customer" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900/50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Tambah Master Pelanggan
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-customer">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="create" method="POST">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2 max-h-[50vh] overflow-y-auto">
                    <div class="col-span-2">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nama pelanggan" required>
                    </div>
                    <div class="col-span-2">
                        <label for="phone_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Handphone</label>
                        <input type="phone" step="0.01" name="phone_number" id="phone_number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nomor handphone">
                    </div>
                    <div class="col-span-2">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" step="0.01" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Email">
                    </div>
                    <div class="col-span-2">
                        <label for="address"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                        <input type="text" step="0.01" name="address" id="address"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Alamat">
                    </div>
                    <div class="col-span-2">
                        <label for="birth_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                        <input datepicker datepicker-autohide datepicker-format="dd-mm-yyyy" id="birth_date"
                            type="text" name="birth_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Tanggal lahir">
                    </div>
                    <div class="col-span-2">
                        <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                            Kelamin</label>
                        <select name="gender" id="gender" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" selected disabled hidden>Pilih Jenis Kelamin</option>
                            <option value="man">Pria</option>
                            <option value="woman">Wanita</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="notes"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                        <textarea id="notes" name="notes" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Catatan"></textarea>
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle form submission
    $('#modal-add-customer form').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serializeArray();
        let data = {};

        $.each(formData, function() {
            data[this.name] = this.value;
        });

        // Show loading icon
        $('#modal-add-customer form').prepend(uiManager.showLoadingModal);
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
                document.querySelector('[data-modal-target="modal-add-customer"]').click();
                dataServiceCustomer.fetchData(1);
            },
            error: (xhr, status, error) => {
                handleFetchError(xhr, status, error);
            },
            complete: function() {
                // Hide loading icon
                $('#modal-add-customer form .absolute').remove();
            }
        });
    });
</script>
