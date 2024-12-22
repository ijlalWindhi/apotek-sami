<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search & Add Button --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="relative sm:w-full md:w-1/2 lg:w-2/6">
                <input type="search" id="search-name"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama, deskripsi" />
                <button type="button" id="search-button"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>

            <x-pages.inventory.master.payment-type.modal-add />
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Akun Bank</th>
                        <th scope="col" class="px-6 py-3 min-w-[10rem]">Nama Akun</th>
                        <th scope="col" class="px-6 py-3 min-w-[20rem]">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    {{-- Table content will be inserted here --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs md:text-sm">
            <div class="data-info"></div>
            <div class="pagination-container"></div>
        </div>
    </div>

    {{-- Modals --}}
    <span data-modal-target="modal-delete" data-modal-toggle="modal-delete" class="hidden"></span>
    <span data-modal-target="modal-edit-payment-type" data-modal-toggle="modal-edit-payment-type" class="hidden"></span>
    <x-pages.inventory.master.payment-type.modal-edit />
    <x-global.modal-delete name="Jenis Pembayaran" />
</x-layout>

<script>
    /**
     * Payment Type Management Module
     * Handles the display, pagination, and interaction with payment type data in a table format
     */

    // Constants
    const PAGINATION_DISPLAY_RANGE = 2;
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 10;
    const TEXT_TRUNCATE_LENGTH = 40;

    /**
     * Data Fetching and Processing
     */
    const dataService = {
        /**
         * Fetches payment type data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (page = 1, search = '') => {
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/master/payment-type/list',
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: PER_PAGE
                },
                success: async (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }
                    await uiManager.refreshUI(response);

                    // Handle reinitialization of modals
                    setTimeout(() => {
                        const modalDelete = new Modal(document.getElementById(
                            'modal-delete'));
                        const modalEdit = new Modal(document.getElementById(
                            'modal-edit-payment-type'));

                        document.querySelectorAll('[data-modal-toggle="modal-delete"]')
                            .forEach(button => {
                                button.addEventListener('click', () => {
                                    modalDelete.show();
                                });
                            });

                        document.querySelectorAll(
                                '[data-modal-toggle="modal-edit-payment-type"]')
                            .forEach(button => {
                                button.addEventListener('click', () => {
                                    modalEdit.show();
                                });
                            });
                    }, 100);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError(
                        'Gagal mengambil data tipe pembayaran. Silahkan coba lagi.');
                },
            });
        },

        getDetail: (id) => {
            $.ajax({
                url: `/inventory/master/payment-type/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    // Fill the modal with data
                    $('#modal-edit-payment-type #name').val(response.data.name);
                    $('#modal-edit-payment-type #account_bank').val(response.data.account_bank);
                    $('#modal-edit-payment-type #name_bank').val(response.data.name_bank);
                    $('#modal-edit-payment-type #description').val(response.data.description);
                    $('#modal-edit-payment-type #is_active').val(response.data
                        .is_active === 1 ? 'true' : 'false');

                    // Add hidden input for form submission
                    if (!$('#modal-edit-payment-type form #payment_type_id').length) {
                        $('#modal-edit-payment-type form').append(
                            `<input type="hidden" id="payment_type_id" name="payment_type_id" value="${id}">`
                        );
                    } else {
                        $('#modal-edit-payment-type form #payment_type_id').val(id);
                    }

                    // Show modal
                    $('#modal-edit-payment-type').removeClass('hidden').addClass('flex');
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: function() {
                    // Hide loading icon
                    $('#modal-edit-payment-type form .absolute').remove();
                }
            });
        },

        deletePaymentType: (id) => {
            $.ajax({
                url: `/inventory/master/payment-type/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Berhasil menghapus data",
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
                complete: () => {
                    // Hide modal
                    $('#modal-delete').removeClass('flex').addClass('hidden');
                }
            });
        }
    };

    /**
     * HTML Templates
     */
    const templates = {
        tableRow: (payment_type) => `
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${utils.escapeHtml(payment_type.name || '-')}
                </th>
                <td class="px-6 py-4">
                    ${payment_type.account_bank || '-'}
                </td>
                <td class="px-6 py-4">
                    ${payment_type.name_bank || '-'}
                </td>
                <td class="px-6 py-4">
                    ${utils.escapeHtml(utils.truncateText(payment_type.description, TEXT_TRUNCATE_LENGTH) || '-')}
                </td>
                <td class="px-6 py-4">
                    ${(payment_type.is_active ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Aktif</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Tidak Aktif</span>')}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    ${templates.actionButtons(payment_type.id)}
                </td>
            </tr>
        `,

        actionButtons: (id) => `
            <button
                id="btn-edit-payment-type"
                class="font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md"
                data-id="${id}"
                data-modal-target="modal-edit-payment-type"
                data-modal-toggle="modal-edit-payment-type"
            >
                <i class="fa-solid fa-pencil"></i>
            </button>
            |
            <button
                id="btn-delete-payment-type"
                class="font-medium text-xs text-white bg-red-500 hover:bg-red-600 h-8 w-8 rounded-md"
                data-id="${id}"
                data-modal-target="modal-delete"
                data-modal-toggle="modal-delete"
            >
                <i class="fa-solid fa-trash"></i>
            </button>
        `,

        loadingModal: '<div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90"><i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i></div>',
    };

    /**
     * Event Handlers
     */
    const eventHandlers = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Search input handler with debounce
            let searchTimeout;
            $('#search-name').on('input', function() {
                const searchValue = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    debug.log('Search', 'Triggering search...');
                    urlManager.updateParams({
                        search: searchValue,
                        page: 1
                    });
                    dataService.fetchData(1, searchValue);
                }, DEBOUNCE_DELAY);
            });

            // Pagination click handler
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                const currentSearch = $('#search-name').val();

                debug.log('Pagination', `Changing to page ${page}`);
                urlManager.updateParams({
                    page,
                    search: currentSearch
                });
                dataService.fetchData(page, currentSearch);
            });

            // Delete confirmation handler
            $("body").on('click', '#btn-delete-payment-type', function() {
                let payment_type_id = $(this).data('id');

                // Get payment type name from the same row
                let payment_type_name = $(this).closest('tr').find('th').text().trim();

                // Update modal content
                $('#modal-delete h3').text(
                    `Apakah anda yakin ingin menghapus data ${payment_type_name} ini?`);

                // Update onclick attribute of confirm delete button
                $('#modal-delete button[data-modal-hide="modal-delete"].bg-red-600').attr('onclick',
                    `dataService.deletePaymentType(${payment_type_id})`);
            });

            // Browser navigation handler
            window.addEventListener('popstate', function() {
                const params = urlManager.getParams();
                $('#search-name').val(params.search);
                dataService.fetchData(params.page, params.search);
            });

            // Edit payment type handler
            $('body').on('click', '#btn-edit-payment-type', function() {
                let payment_type_id = $(this).data('id');

                // Reset form
                $('#modal-edit-payment-type form').trigger('reset');

                // Show loading icon
                $('#modal-edit-payment-type form').prepend(templates.loadingModal);

                // Fetch data
                dataService.getDetail(payment_type_id);
            });
        },
    };

    /**
     * Initialize the payment type table functionality
     */
    function initPaymentTypeTable() {
        debug.log('Init', 'Initializing payment type table...');
        const params = urlManager.getParams();
        $('#search-name').val(params.search);
        dataService.fetchData(params.page, params.search);
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initPaymentTypeTable();
        eventHandlers.init();
    });
</script>
