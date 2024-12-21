<div id="modal-edit-payment-type" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edit Master Tipe Pembayaran
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-edit-payment-type">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nama pembayaran" required>
                    </div>
                    <div class="col-span-2">
                        <label for="account_bank"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Akun
                            Bank</label>
                        <input type="text" name="account_bank" id="account_bank"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Rekening bank">
                    </div>
                    <div class="col-span-2">
                        <label for="name_bank" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            Akun</label>
                        <input type="text" name="name_bank" id="name_bank"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nama pemiliki">
                    </div>
                    <div class="col-span-2">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Deskripsi pajak"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label for="is_active"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status <span
                                class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" selected disabled hidden>Status</option>
                            <option value="true">Aktif</option>
                            <option value="false">Tidak Aktif</option>
                        </select>
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
    $('#modal-edit-payment-type form').on('submit', function(e) {
        e.preventDefault();

        let payment_type_id = $('#payment_type_id').val();
        let formData = $(this).serializeArray();
        let data = {};

        $.each(formData, function() {
            if (this.name === 'is_active') {
                this.value = this.value === 'true';
            }
            data[this.name] = this.value;
        });

        // Show loading icon
        $('#modal-edit-payment-type form').prepend(templates.loadingModal);
        $.ajax({
            url: `/inventory/master/payment-type/${payment_type_id}`,
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json",
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function(response) {
                // Close modal
                $('#modal-edit-payment-type').removeClass('flex').addClass('hidden');
                Swal.fire({
                    icon: "success",
                    title: "Berhasil memperbarui data",
                    showConfirmButton: false,
                    timer: 1500
                });

                // Fetch data again
                const params = urlManager.getParams();
                dataService.fetchData(params.page, params.search);
            },
            error: (xhr, status, error) => {
                handleFetchError(xhr, status, error);
            },
            complete: function() {
                // Hide loading icon
                $('#modal-edit-payment-type form .absolute').remove();
            }
        });
    });

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlers.init();
    });
</script>
