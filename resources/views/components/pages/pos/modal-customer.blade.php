<button data-modal-target="modal-customer" data-modal-toggle="modal-customer" class="hide"></button>
<div id="modal-customer" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between py-3 px-4 md:px-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Cari Pelanggan
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-customer">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="flex justify-between items-center gap-2 px-4 md:px-6 mt-3">
                <form class="w-full">
                    @csrf
                    <div class="relative w-full">
                        <input type="search" id="search-name"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="Cari nama pelanggan" />
                        <button type="button" id="search-button"
                            class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </form>
                <x-button color="blue">
                    <i class="fa-solid fa-plus"></i>
                </x-button>
            </div>
            <div class="flex flex-col px-4 py-3">
                <div class="flex gap-3 items-center justify-between border-y py-3 px-2">
                    <div class="flex gap-1 items-center">
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gray-500 rounded-full">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </span>
                        <div class="flex flex-col">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">John Doe</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">082190219021</p>
                        </div>
                    </div>
                    <x-button color="blue" class="h-8">
                        Pilih
                    </x-button>
                </div>
                <div class="flex gap-3 items-center justify-between border-y py-3 px-2">
                    <div class="flex gap-1 items-center">
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gray-500 rounded-full">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </span>
                        <div class="flex flex-col">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">John Doe</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">082190219021</p>
                        </div>
                    </div>
                    <x-button color="blue" class="h-8">
                        Pilih
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.altKey && event.key === 'c') {
            event.preventDefault();
            document.querySelector('[data-modal-target="modal-customer"]').click();
        }
    });
</script>
