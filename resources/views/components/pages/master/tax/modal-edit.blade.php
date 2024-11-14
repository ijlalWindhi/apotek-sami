<div id="modal-edit-tax" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edit Master Pajak
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-edit-tax">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nama pajak" required>
                    </div>
                    <div class="col-span-2">
                        <label for="rate"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Besaran</label>
                        <input type="number" step="0.01" name="rate" id="rate"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="1.5%" required>
                    </div>
                    <div class="col-span-2">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                        <textarea id="description" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Deskripsi pajak"></textarea>
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
    // Show modal
    $('body').on('click', '#btn-edit-tax', function() {
        let post_id = $(this).data('id');
        let loading = '<i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i>';

        // Reset form
        $('#modal-edit-tax form').trigger('reset');

        // Show loading icon
        $('#modal-edit-tax form').prepend(
            `<div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90">${loading}</div>`
        );
        $.ajax({
            url: `/master/tax/${post_id}`,
            type: "GET",
            cache: false,
            success: function(response) {
                // Fill the modal with data
                $('#modal-edit-tax #name').val(response.data.name);
                $('#modal-edit-tax #rate').val(response.data.rate);
                $('#modal-edit-tax #description').val(response.data.description);

                // Add hidden input for form submission
                if (!$('#modal-edit-tax form #tax_id').length) {
                    $('#modal-edit-tax form').append(
                        `<input type="hidden" id="tax_id" name="tax_id" value="${post_id}">`);
                } else {
                    $('#modal-edit-tax form #tax_id').val(post_id);
                }

                // Show modal
                $('#modal-edit-tax').removeClass('hidden').addClass('flex');
            },
            error: function(response) {
                // Handle validation errors
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    alert(value);
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: value,
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            },
            complete: function() {
                // Hide loading icon
                $('#modal-edit-tax form .absolute').remove();
            }
        });
    });

    // Handle form submission
    $('#modal-edit-tax form').on('submit', function(e) {
        e.preventDefault();

        let tax_id = $('#tax_id').val();
        let formData = $(this).serializeArray();
        let data = {};
        let loading = '<i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i>';

        $.each(formData, function() {
            data[this.name] = this.value;
        });

        // Show loading icon
        $('#modal-edit-tax form').prepend(
            `<div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90">${loading}</div>`
        );
        $.ajax({
            url: `/master/tax/${tax_id}`,
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
                $('#modal-edit-tax').removeClass('flex').addClass('hidden');
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Data berhasil diperbarui",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: function(response) {
                // Handle validation errors
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    alert(value);
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: value,
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            },
            complete: function() {
                // Hide loading icon
                $('#modal-edit-tax form .absolute').remove();
            }
        });
    });
</script>
