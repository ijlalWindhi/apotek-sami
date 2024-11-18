<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="flex flex-col gap-3">
        <div class="grid grid-cols-3 justify-between items-center gap-3 w-full h-full">
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Pelanggan</h2>
                <div class="flex w-full justify-between gap-2 items-center">
                    <p class="text-xs md:text-sm">John Doe</p>
                    <div class="flex gap-1">
                        <button id="btn-search-customer"
                            class="delete-button font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Dokter</h2>
                <div class="flex w-full justify-between gap-2 items-center">
                    <p class="text-xs md:text-sm">John Doe</p>
                    <div class="flex gap-1">
                        <button id="btn-search-customer"
                            class="delete-button font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Resep</h2>
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
        <x-button color="blue" data-modal-target="modal-add-tax" data-modal-toggle="modal-add-tax" class="w-full">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Tambah </span>
        </x-button>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
        <div class="grid grid-cols-3 justify-between items-center gap-3 w-full h-full">
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Diskon</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp10.000</p>
            </div>
            <div class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1">
                <h2 class="text-sm md:text-base font-semibold">Biaya Lain</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp5.000</p>
            </div>
            <div
                class="flex flex-col gap-1 border p-4 justify-between rounded-md h-24 col-span-3 md:col-span-1 text-blue-500">
                <h2 class="text-sm md:text-base font-semibold">Total</h2>
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold">Rp25.000</p>
            </div>
        </div>
        <x-button color="green" data-modal-target="modal-add-tax" data-modal-toggle="modal-add-tax" class="w-full">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="ms-2">Bayar</span>
        </x-button>
    </div>
    </x-layout-pos>
