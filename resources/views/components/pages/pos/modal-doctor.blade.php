{{-- Button Add --}}
<button id="btn-search-doctor" data-modal-target="modal-doctor" data-modal-toggle="modal-doctor"
    class="delete-button font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md">
    <i class="fa-solid fa-plus"></i>
</button>

{{-- Modal --}}
<div id="modal-doctor" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between py-3 px-4 md:px-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Cari Dokter
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="modal-doctor">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal-body" class="relative">
                <div class="flex justify-between items-center gap-2 px-4 md:px-6 mt-3">
                    <form class="w-full">
                        @csrf
                        <div class="relative w-full">
                            <input type="search" id="search-doctor"
                                class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder="Cari berdasarkan nama, email, no handphone, no sip" />
                            <button type="button" id="search-button"
                                class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </form>
                    <x-pages.pos.modal-add-doctor></x-pages.pos.modal-add-doctor>
                </div>
                <div id="doctor-content" class="flex flex-col px-4 py-3">
                    {{-- Data content will be inserted here --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Doctor Modal
     * Handles the display, and interaction with tax data in a table format
     */

    /**
     * Data Fetching and Processing
     */
    const dataServiceDoctor = {
        /**
         * Fetches tax data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (page = 1, search = '') => {
            $('#modal-doctor #modal-body').prepend(uiManager.showLoadingModal);
            $.ajax({
                url: '/inventory/pharmacy/doctor/list',
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: PER_PAGE
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    } else {
                        const data = response.data;
                        if (data.length === 0) {
                            $('#modal-doctor #modal-body #doctor-content').html(`
                                <div class="flex items center justify-center py-3 text-red-600">
                                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                                    <p class="text-sm text-center">Tidak ada data</p>
                                </div>
                            `);
                        } else {
                            const rows = data.map((item) => templateDoctor.generateRow(item));
                            $('#modal-doctor #modal-body #doctor-content').html(rows.join(''));
                        }
                    }
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data pajak. Silahkan coba lagi.');
                },
                complete: () => {
                    // Hide loading icon
                    $('#modal-doctor #modal-body .absolute').remove();
                }
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlersDoctor = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Search input handler with debounce
            let searchTimeout;
            $('#search-doctor').on('input', function() {
                const searchValue = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    dataServiceDoctor.fetchData(1, searchValue);
                }, DEBOUNCE_DELAY);
            });

            // Keyboard shortcut to open the modal
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.altKey && event.key === 'd') {
                    event.preventDefault();
                    document.querySelector('[data-modal-target="modal-doctor"]').click();
                }
            });

            // Event click modal
            $('[data-modal-toggle="modal-doctor"]').on('click', function() {
                const target = $(this).data('modal-target');
                $(`#${target}`).toggleClass('hidden');
                if (!$(`#${target}`).hasClass('hidden')) {
                    $('#search-doctor').val('');
                    dataServiceDoctor.fetchData(1);
                }
            });

            // Event click button pilih
            $("body").on('click', '#btn-select-doctor', function() {
                const doctor_id = $(this).data('id');
                const doctor_name = $(this).closest('.data-doctor').find('.text-sm.font-semibold')
                    .text();

                // Set the doctor ID and name
                $('#doctor').attr('data-id', doctor_id).text(doctor_name);

                // Close the modal
                $('[data-modal-target="modal-doctor"]').click();
            });
        }
    };

    /**
     * Template Manager
     */
    const templateDoctor = {
        generateRow: (data) => {
            return `
                <div class="flex gap-3 items-center justify-between border-y py-3 px-2 data-doctor">
                    <div class="flex gap-1 items-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gray-500 rounded-full">
                            ${data.name.substring(0, 2).toUpperCase()}
                        </span>
                        <div class="flex flex-col">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">${data.name}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${data.phone_number || '-'}</p>
                        </div>
                    </div>
                    <x-button color="blue" class="h-8" data-id=${data.id} id="btn-select-doctor">
                        Pilih
                    </x-button>
                </div>
            `;
        }
    }

    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersDoctor.init();
    });
</script>
