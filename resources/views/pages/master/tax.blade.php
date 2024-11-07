<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <form class="relative sm:w-full md:w-1/2 lg:w-2/6" action="{{ route('tax.search') }}" method="POST">
                @csrf
                <input type="search" id="search-dropdown" name="name"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama" required />
                <button type="submit"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </form>

            {{-- Modal Add --}}
            <x-pages.master.tax.modal-add />
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Besaran
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taxs as $tax)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $tax->name ?? '-' }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $tax->rate ?? '0' }}%
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($tax->description, 40, '...') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <div class="edit-button font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer"
                                    id="btn-edit-tax" data-id="{{ $tax->id }}" data-modal-target="modal-edit-tax"
                                    data-modal-toggle="modal-edit-tax">
                                    <i class="fa-solid fa-pencil"></i>
                                </div>
                                |
                                <div class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer"
                                    data-modal-target="modal-delete" data-modal-toggle="modal-delete"
                                    id="btn-delete-tax" data-id="{{ $tax->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <nav aria-label="Page navigation example" class="self-end">
            <ul class="inline-flex -space-x-px text-base h-10">
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                </li>
                <li>
                    <a href="#" aria-current="page"
                        class="flex items-center justify-center px-4 h-10 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">4</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">5</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- Modal Edit --}}
    <x-pages.master.tax.modal-edit />

    {{-- Modal Delete --}}
    <x-global.modal-delete name="pajak" />
</x-layout>

{{-- JS SCRIPT --}}
<script>
    // Handle delete button click
    $('body').on('click', '#btn-delete-tax', function() {
        let tax_id = $(this).data('id');

        // Get tax name from the same row
        let tax_name = $(this).closest('tr').find('th').text().trim();

        // Update modal content
        $('#modal-delete h3').text(`Apakah anda yakin ingin menghapus data ${tax_name} ini?`);

        // Update onclick attribute of confirm delete button
        $('#modal-delete button[data-modal-hide="modal-delete"].bg-red-600').attr('onclick',
            `deleteTax(${tax_id})`);
    });

    // Function to handle delete
    function deleteTax(id) {
        $.ajax({
            url: `/master/tax/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Hide modal
                $('#modal-delete').removeClass('flex').addClass('hidden');

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Data berhasil dihapus",
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
            }
        });
    }
</script>
