<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search & Add Button --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="relative sm:w-full md:w-1/2 lg:w-2/6">
                <input type="search" id="search-name"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama, email" />
                <button type="button" id="search-button"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>

            <x-pages.inventory.pharmacy.employee.modal-add />
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
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
    <span data-modal-target="modal-edit-employee" data-modal-toggle="modal-edit-employee" class="hidden"></span>
    <x-pages.inventory.pharmacy.employee.modal-edit />
    <x-global.modal-delete name="pengguna" />
</x-layout>

<script>
    /**
     * Employee Management Module
     * Handles the display, pagination, and interaction with employee data in a table format
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
         * Fetches employee data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (page = 1, search = '') => {
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/pharmacy/employee/list',
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
                            'modal-edit-employee'));

                        document.querySelectorAll('[data-modal-toggle="modal-delete"]')
                            .forEach(button => {
                                button.addEventListener('click', () => {
                                    modalDelete.show();
                                });
                            });

                        document.querySelectorAll('[data-modal-hide="modal-delete"]')
                            .forEach(button => {
                                button.addEventListener('click', () => {
                                    modalDelete.hide();
                                });
                            });

                        document.querySelectorAll(
                                '[data-modal-toggle="modal-edit-employee"]')
                            .forEach(button => {
                                button.addEventListener('click', () => {
                                    modalEdit.show();
                                });
                            });
                    }, 100);
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                    uiManager.showError('Gagal mengambil data pajak. Silahkan coba lagi.');
                },
            });
        },

        getDetail: (id) => {
            $.ajax({
                url: `/inventory/pharmacy/employee/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    // Fill the modal with data
                    $('#modal-edit-employee #name').val(response.data.name);
                    $('#modal-edit-employee #email').val(response.data.email);
                    $('#modal-edit-employee #role').val(response.data.role);

                    // Add hidden input for form submission
                    if (!$('#modal-edit-employee form #employee_id').length) {
                        $('#modal-edit-employee form').append(
                            `<input type="hidden" id="employee_id" name="employee_id" value="${id}">`
                        );
                    } else {
                        $('#modal-edit-employee form #employee_id').val(id);
                    }

                    // Show modal
                    $('#modal-edit-employee').removeClass('hidden').addClass('flex');
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: function() {
                    // Hide loading icon
                    $('#modal-edit-employee form .absolute').remove();
                }
            });
        },

        deleteEmployee: (id) => {
            $.ajax({
                url: `/inventory/pharmacy/employee/${id}`,
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
        tableRow: (employee) => `
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${employee.name || '-'}
                </th>
                <td class="px-6 py-4">
                    ${employee.email || '-'}
                </td>
                <td class="px-6 py-4">
                    ${(employee.role || '-')}
                </td>
                <td class="px-6 py-4 flex gap-2 items-center">
                    ${templates.actionButtons(employee.id)}
                </td>
            </tr>
        `,

        actionButtons: (id) => `
            <button
                id="btn-edit-employee"
                class="font-medium text-xs text-white bg-blue-500 hover:bg-blue-600 h-8 w-8 rounded-md"
                data-id="${id}"
                data-modal-target="modal-edit-employee"
                data-modal-toggle="modal-edit-employee"
            >
                <i class="fa-solid fa-pencil"></i>
            </button>
            |
            <button
                id="btn-delete-employee"
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
            $("body").on('click', '#btn-delete-employee', function() {
                let employee_id = $(this).data('id');

                // Get employee name from the same row
                let employee_name = $(this).closest('tr').find('th').text().trim();

                // Update modal content
                $('#modal-delete h3').text(
                    `Apakah anda yakin ingin menghapus data ${employee_name} ini?`);

                // Update onclick attribute of confirm delete button
                $('#modal-delete button[data-modal-hide="modal-delete"].bg-red-600').attr('onclick',
                    `dataService.deleteEmployee(${employee_id})`);
            });

            // Browser navigation handler
            window.addEventListener('popstate', function() {
                const params = urlManager.getParams();
                $('#search-name').val(params.search);
                dataService.fetchData(params.page, params.search);
            });

            // Edit employee handler
            $('body').on('click', '#btn-edit-employee', function() {
                let employee_id = $(this).data('id');

                // Reset form
                $('#modal-edit-employee form').trigger('reset');

                // Show loading icon
                $('#modal-edit-employee form').prepend(templates.loadingModal);

                // Fetch data
                dataService.getDetail(employee_id);
            });
        },
    };

    /**
     * Initialize the employee table functionality
     */
    function initEmployeeTable() {
        debug.log('Init', 'Initializing employee table...');
        const params = urlManager.getParams();
        $('#search-name').val(params.search);
        dataService.fetchData(params.page, params.search);
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initEmployeeTable();
        eventHandlers.init();
    });
</script>
