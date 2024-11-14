{{-- Button Add --}}
<x-button color="blue" data-modal-target="modal-add-tax" data-modal-toggle="modal-add-tax">
    <i class="fa-solid fa-plus"></i>
    <span class="ms-2">Tambah</span>
</x-button>

{{-- Modal --}}
<div id="modal-add-tax" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Tambah Master Pajak
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-add-tax">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="create" method="POST">
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
                        <textarea id="description" name="description" rows="4"
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
    $(document).ready(function() {
        $('#create').submit(function(e) {
            e.preventDefault();
            handleCreate()
        })
    })

    function handleCreate() {
        let formData = $(this).serializeArray();
        let data = {};

        $.each(formData, function() {
            data[this.name] = this.value;
        });

        $.ajax({
            url: `/master/tax`,
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json",
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                // Close modal
                $('#modal-add-tax').removeClass('flex').addClass('hidden');
                Swal.fire({
                    icon: "success",
                    title: "Data berhasil diperbarui",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: handleError,
            complete: function() {
                // Hide loading icon
                hideLoading();
            }
        });
    }

    function showLoading() {
        let loading = '<i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i>';
        $('#create').prepend(
            `<div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90">${loading}</div>`
        );
    }

    function hideLoading() {
        $('#create .absolute').remove();
    }

    function handleError(xhr, status, error) {
        hideLoading();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat memproses data! Silahkan hubungi administrator.',
        });
        updateTable([]);
    }
</script>
