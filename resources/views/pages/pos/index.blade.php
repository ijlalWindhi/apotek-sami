<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="flex flex-col gap-3">
        {{-- Button More Information --}}
        <div class="grid grid-cols-3 justify-between items-center gap-3 w-full h-full">
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Pelanggan <span class="text-gray-400">[CTRL+ALT+C]</span>
                </h2>
                <div class="flex w-full justify-between gap-2 items-center">
                    <p id="customer" class="text-xs md:text-sm">-</p>
                    <x-pages.pos.modal-customer></x-pages.pos.modal-customer>
                </div>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Dokter <span class="text-gray-400">[CTRL+ALT+D]</span>
                </h2>
                <div class="flex w-full justify-between gap-2 items-center">
                    <p id="doctor" class="text-xs md:text-sm">-</p>
                    <x-pages.pos.modal-doctor></x-pages.pos.modal-doctor>
                </div>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Resep <span class="text-gray-400">[CTRL+ALT+R]</span>
                </h2>
                <div class="flex w-full justify-between gap-2 items-center">
                    <p class="text-xs md:text-sm">Flu Batuk</p>
                    <div class="flex gap-1">
                        <button id="btn-search-customer"
                            class="delete-button font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table List Product --}}
        <x-button color="blue" class="w-full space-x-1 mt-4">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Tambah</span><span class="text-gray-300">[CTRL+ALT+A]</span>
        </x-button>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Produk</th>
                        <th scope="col" class="px-6 py-3">Jumlah</th>
                        <th scope="col" class="px-6 py-3">Satuan</th>
                        <th scope="col" class="px-6 py-3">Tuslah</th>
                        <th scope="col" class="px-6 py-3">Harga Jual</th>
                        <th scope="col" class="px-6 py-3">Diskon</th>
                        <th scope="col" class="px-6 py-3">Sub Total</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tax-table-body">
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <th scope="row" class="px-6 py-4">
                            1
                        </th>
                        <td class="px-6 py-4 flex flex-col gap-1">
                            <p>Dipa C 50mg 30s</p>
                            <span class="text-xs text-gray-500">Stock: 87 pcs</span>
                        </td>
                        <td class="px-6 py-4">
                            1
                        </td>
                        <td class="px-6 py-4">
                            pcs
                        </td>
                        <td class="px-6 py-4">
                            Rp1.000
                        </td>
                        <td class="px-6 py-4">
                            Rp10.000
                        </td>
                        <td class="px-6 py-4">
                            0%
                        </td>
                        <td class="px-6 py-4">
                            Rp10.000
                        </td>
                        <td class="px-6 py-4">
                            <button
                                class="delete-button font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <th scope="row" class="px-6 py-4">
                            1
                        </th>
                        <td class="px-6 py-4 flex flex-col gap-1">
                            <p>Dipa C 50mg 30s</p>
                            <span class="text-xs text-gray-500">Stock: 87 pcs</span>
                        </td>
                        <td class="px-6 py-4">
                            1
                        </td>
                        <td class="px-6 py-4">
                            pcs
                        </td>
                        <td class="px-6 py-4">
                            Rp1.000
                        </td>
                        <td class="px-6 py-4">
                            Rp10.000
                        </td>
                        <td class="px-6 py-4">
                            0%
                        </td>
                        <td class="px-6 py-4">
                            Rp10.000
                        </td>
                        <td class="px-6 py-4">
                            <button
                                class="delete-button font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <th scope="row" class="px-6 py-4">
                            1
                        </th>
                        <td class="px-6 py-4 flex flex-col gap-1">
                            <p>Dipa C 50mg 30s</p>
                            <span class="text-xs text-gray-500">Stock: 87 pcs</span>
                        </td>
                        <td class="px-6 py-4">
                            1
                        </td>
                        <td class="px-6 py-4">
                            pcs
                        </td>
                        <td class="px-6 py-4">
                            Rp1.000
                        </td>
                        <td class="px-6 py-4">
                            Rp10.000
                        </td>
                        <td class="px-6 py-4">
                            0%
                        </td>
                        <td class="px-6 py-4">
                            Rp10.000
                        </td>
                        <td class="px-6 py-4">
                            <button
                                class="delete-button font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Detail Information Transaction --}}
        <div class="grid grid-cols-3 justify-between items-center gap-3 w-full h-full">
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Catatan</h2>
                <input type="text" name="deskripsi" id="deskripsi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Catatan transaksi">
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Status</h2>
                <select name="status" id="status" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected disabled hidden>Pilih status</option>
                    <option value="0">Terbayar</option>
                    <option value="1">Belum Lunas</option>
                </select>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Dibayarkan</h2>
                <input type="text" name="dibayarkan" id="dibayarkan"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Jumlah dibayarkan pelanggan">
            </div>
        </div>
        <div class="grid grid-cols-4 justify-between items-center gap-3 w-full h-full">
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Diskon</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp10.000</p>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Biaya Lain</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp5.000</p>
            </div>
            <div
                class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1 text-green-500">
                <h2 class="text-sm md:text-base font-semibold">Total</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp25.000</p>
            </div>
            <div
                class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1 text-red-500 ">
                <h2 class="text-sm md:text-base font-semibold">Kembalian</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp5.000</p>
            </div>
        </div>

        {{-- Button Transaction --}}
        <div class="flex flex-col md:flex-row gap-3 justify-between">
            <x-button color="red" class="w-full space-x-1">
                <i class="fa-solid fa-trash"></i>
                <span class="ms-2">Bersihkan List Produk</span><span class="text-gray-300">[CTRL+ALT+W]</span>
            </x-button>
            <x-button color="gray" class="w-full space-x-1">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span class="ms-2">Cari Transaksi</span><span class="text-gray-300">[CTRL+ALT+S]</span>
            </x-button>
            <x-button color="gray" class="w-full space-x-1">
                <i class="fa-solid fa-credit-card"></i>
                <span class="ms-2">Detail Transaksi</span><span class="text-gray-300">[CTRL+ALT+P]</span>
            </x-button>
        </div>
        <x-button color="green" class="w-full h-12 space-x-1" id="btn-payment">
            <i class="fa-solid fa-floppy-disk"></i>
            <span class="ms-2">Bayar</span><span class="text-gray-300">[F9]</span>
        </x-button>
    </div>

    {{-- Modal --}}
    <x-pages.pos.modal-recipe></x-pages.pos.modal-recipe>
</x-layout>

<script>
    // Constants
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 999999;

    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');

        $("body").on('click', '#btn-payment', function() {
            const doctor_id = $('#doctor').attr('data-id');
        });
    });
</script>
