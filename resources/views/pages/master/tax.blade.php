<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col gap-4 w-full">
        {{-- Search & Add Button --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="relative sm:w-full md:w-1/2 lg:w-2/6">
                <input type="search" id="search-name"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama" />
                <button type="button" id="search-button"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>

            <x-pages.master.tax.modal-add />
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Besaran</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tax-table-body">
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
    <x-pages.master.tax.modal-edit />
    <x-global.modal-delete name="pajak" />
</x-layout>

<script>
    /**
     * Tax Management Module
     * Handles the display, pagination, and interaction with tax data in a table format
     */

    // Constants
    const PAGINATION_DISPLAY_RANGE = 2;
    const DEBOUNCE_DELAY = 500;
    const PER_PAGE = 5;
    const TEXT_TRUNCATE_LENGTH = 40;

    // Debug utility for consistent logging
    const debug = {
        log: (section, data) => console.log(`[${section}]:`, data),
        error: (section, error) => console.error(`[${section} Error]:`, error)
    };

    /**
     * URL Parameter Management
     */
    const urlManager = {
        /**
         * Retrieves current parameters from URL
         * @returns {Object} Object containing search and page parameters
         */
        getParams: () => {
            const urlParams = new URLSearchParams(window.location.search);
            return {
                search: urlParams.get('search') || '',
                page: parseInt(urlParams.get('page')) || 1
            };
        },

        /**
         * Updates URL parameters without page reload
         * @param {Object} params - Parameters to update
         */
        updateParams: (params) => {
            const url = new URL(window.location.href);
            Object.entries(params).forEach(([key, value]) => {
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
            });
            window.history.pushState({}, '', url);
        }
    };

    /**
     * Data Fetching and Processing
     */
    const dataService = {
        /**
         * Fetches tax data from the server
         * @param {number} page - Page number to fetch
         * @param {string} search - Search term
         */
        fetchData: (page = 1, search = '') => {
            debug.log('Fetch', {
                page,
                search
            });
            uiManager.showLoading();

            $.ajax({
                url: '/inventory/master/tax/list',
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: PER_PAGE
                },
                success: (response) => {
                    if (!response?.success) {
                        throw new Error('Invalid response format');
                    }
                    uiManager.refreshUI(response);
                },
                error: (xhr, status, error) => {
                    debug.error('Ajax', {
                        xhr,
                        status,
                        error
                    });
                    uiManager.showError('Failed to fetch data. Please try again.');
                },
            });
        }
    };

    /**
     * UI Management and Rendering
     */
    const uiManager = {
        /**
         * Refreshes all UI components
         * @param {Object} response - Server response containing data and meta information
         */
        refreshUI: (response) => {
            try {
                console.log(response);
                uiManager.updateTable(response.data);
                uiManager.updatePagination(response.meta);
                uiManager.updateInfo(response.meta);
            } catch (error) {
                debug.error('RefreshUI', error);
                uiManager.showError('Error updating display');
            }
        },

        /**
         * Updates the tax data table
         * @param {Array} data - Array of tax objects
         */
        updateTable: (data) => {
            debug.log('UpdateTable', 'Starting table update');
            const tbody = $('#tax-table-body');

            if (!Array.isArray(data) || data.length === 0) {
                tbody.html(templates.emptyTable());
                return;
            }

            tbody.html(data.map(tax => templates.tableRow(tax)).join(''));
            debug.log('UpdateTable', 'Table updated successfully');
        },

        /**
         * Updates pagination controls
         * @param {Object} meta - Pagination metadata
         */
        updatePagination: (meta) => {
            debug.log('UpdatePagination', meta);
            const container = $('.pagination-container');

            if (!meta || meta.last_page <= 1) {
                container.hide();
                return;
            }

            container.show().html(templates.pagination(meta));
        },

        /**
         * Updates data info text
         * @param {Object} meta - Pagination metadata
         */
        updateInfo: (meta) => {
            debug.log('UpdateInfo', meta);
            $('.data-info').html(templates.dataInfo(meta));
        },

        /**
         * Shows loading state
         */
        showLoading: () => {
            $('#tax-table-body').html(templates.loading());
        },

        /**
         * Shows error message
         * @param {string} message - Error message to display
         */
        showError: (message) => {
            $('#tax-table-body').html(templates.error(message));
        }
    };

    /**
     * HTML Templates
     */
    const templates = {
        tableRow: (tax) => `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${utils.escapeHtml(tax.name || '-')}
            </th>
            <td class="px-6 py-4">
                ${tax.rate || '0'}%
            </td>
            <td class="px-6 py-4">
                ${utils.escapeHtml(utils.truncateText(tax.description, TEXT_TRUNCATE_LENGTH) || '-')}
            </td>
            <td class="px-6 py-4 flex gap-2">
                ${templates.actionButtons(tax.id)}
            </td>
        </tr>
    `,

        actionButtons: (id) => `
        <button class="edit-button font-medium text-blue-600 dark:text-blue-500 hover:underline"
            data-id="${id}" 
            data-modal-target="modal-edit-tax"
            data-modal-toggle="modal-edit-tax">
            <i class="fa-solid fa-pencil"></i>
        </button>
        |
        <button class="delete-button font-medium text-red-600 dark:text-red-500 hover:underline"
            data-id="${id}" 
            data-modal-target="modal-delete"
            data-modal-toggle="modal-delete">
            <i class="fa-solid fa-trash"></i>
        </button>
    `,

        emptyTable: () => `
        <tr>
            <td colspan="4" class="px-6 py-4 text-center">
                Tidak ada data
            </td>
        </tr>
    `,

        loading: () => `
        <tr>
            <td colspan="4" class="px-6 py-4 text-center">
                <div class="flex justify-center items-center">
                    <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                    Loading...
                </div>
            </td>
        </tr>
    `,

        error: (message) => `
        <tr>
            <td colspan="4" class="px-6 py-4 text-center text-red-600">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                ${utils.escapeHtml(message)}
            </td>
        </tr>
    `,

        dataInfo: (meta) => `
        Menampilkan ${meta.from || 0} ke ${meta.to || 0} dari ${meta.total || 0} total data
    `,

        pagination: (meta) => {
            const currentPage = meta.current_page;
            const lastPage = meta.last_page;

            return `
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                <div class="flex-1 sm:flex sm:items-center sm:justify-end">
                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            ${templates.paginationPrevButton(currentPage)}
                            ${templates.paginationItems(currentPage, lastPage)}
                            ${templates.paginationNextButton(currentPage, lastPage)}
                        </span>
                    </div>
                </div>
            </nav>
        `;
        },

        paginationItems: (currentPage, lastPage) => {
            const items = [];
            const displayRange = 2;
            const currentSearch = document.querySelector('#search-name')?.value || '';

            // Tentukan range halaman yang akan ditampilkan
            let startPage = Math.max(1, currentPage - displayRange);
            let endPage = Math.min(lastPage, currentPage + displayRange);

            // Tambahkan halaman pertama jika tidak termasuk dalam range
            if (startPage > 1) {
                items.push(templates.paginationLink(1));
                if (startPage > 2) {
                    items.push(templates.paginationDots());
                }
            }

            // Generate halaman dalam range
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    items.push(templates.paginationCurrentPage(i));
                } else {
                    items.push(templates.paginationLink(i));
                }
            }

            // Tambahkan halaman terakhir jika tidak termasuk dalam range
            if (endPage < lastPage) {
                if (endPage < lastPage - 1) {
                    items.push(templates.paginationDots());
                }
                items.push(templates.paginationLink(lastPage));
            }

            return items.join('');
        },

        paginationDots: () => `
        <span aria-disabled="true">
            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-xs md:text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">...</span>
        </span>
    `,

        paginationCurrentPage: (page) => `
        <span aria-current="page">
            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-xs md:text-sm font-medium text-white bg-blue-600 border border-gray-300 cursor-default leading-5 dark:border-gray-600">${page}</span>
        </span>
    `,

        paginationLink: (page) => {
            const currentSearch = document.querySelector('#search-name')?.value || '';
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            if (currentSearch) {
                url.searchParams.set('search', currentSearch);
            }

            return `
            <a href="${url.search}"
               class="relative inline-flex items-center px-4 py-2 -ml-px text-xs md:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-gray-300"
               aria-label="Go to page ${page}">
                ${page}
            </a>
        `;
        },

        paginationPrevButton: (currentPage) => {
            const currentSearch = document.querySelector('#search-name')?.value || '';
            const url = new URL(window.location.href);

            if (currentPage > 1) {
                url.searchParams.set('page', currentPage - 1);
                if (currentSearch) {
                    url.searchParams.set('search', currentSearch);
                }

                return `
                <a href="${url.search}" rel="prev"
                   class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            `;
            }

            return `
            <span aria-disabled="true">
                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            </span>
        `;
        },

        paginationNextButton: (currentPage, lastPage) => {
            const currentSearch = document.querySelector('#search-name')?.value || '';
            const url = new URL(window.location.href);

            if (currentPage < lastPage) {
                url.searchParams.set('page', currentPage + 1);
                if (currentSearch) {
                    url.searchParams.set('search', currentSearch);
                }

                return `
                <a href="${url.search}" rel="next"
                   class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            `;
            }

            return `
            <span aria-disabled="true">
                <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            </span>
        `;
        }
    };

    /**
     * Utility Functions
     */
    const utils = {
        escapeHtml: (str) => {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        },

        truncateText: (text, length) => {
            if (!text) return '';
            return text.length > length ? text.substring(0, length) + '...' : text;
        }
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

            // Browser navigation handler
            window.addEventListener('popstate', function() {
                const params = urlManager.getParams();
                $('#search-name').val(params.search);
                dataService.fetchData(params.page, params.search);
            });

            // Delete confirmation handler
            $('#modal-delete button[data-modal-hide="modal-delete"].bg-red-600').attr('onclick',
                `deleteTax(${tax_id})`);
        }
    };

    /**
     * Initialize the tax table functionality
     */
    function initTaxTable() {
        debug.log('Init', 'Initializing tax table...');
        const params = urlManager.getParams();
        $('#search-name').val(params.search);
        dataService.fetchData(params.page, params.search);
    }

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        initTaxTable();
        eventHandlers.init();
    });
</script>
