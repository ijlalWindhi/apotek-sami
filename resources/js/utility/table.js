export const table = {
    emptyTable: () => `
        <tr>
            <td colspan="100" class="px-6 py-4">
                <div class="text-red-600 flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    <p class="text-sm text-center">Tidak ada data</p>
                </div>
            </td>
        </tr>
    `,

    loading: () => `
        <tr>
            <td colspan="100" class="px-6 py-4 text-center">
                <div class="flex justify-center items-center">
                    <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                    Loading...
                </div>
            </td>
        </tr>
    `,

    error: (message) => `
        <tr>
            <td colspan="100" class="px-6 py-4 text-center text-red-600">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                ${utils.escapeHtml(message)}
            </td>
        </tr>
    `,

    dataInfo: (meta) => `
    Menampilkan ${meta.from || 0} ke ${meta.to || 0} dari ${
        meta.total || 0
    } total data
`,

    pagination: (meta) => {
        const currentPage = meta.current_page;
        const lastPage = meta.last_page;

        return `
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                <div class="flex-1 sm:flex sm:items-center sm:justify-end">
                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            ${table.paginationPrevButton(currentPage)}
                            ${table.paginationItems(currentPage, lastPage)}
                            ${table.paginationNextButton(currentPage, lastPage)}
                        </span>
                    </div>
                </div>
            </nav>
        `;
    },

    paginationItems: (currentPage, lastPage) => {
        const items = [];
        const displayRange = 2;
        const currentSearch =
            document.querySelector("#search-name")?.value || "";

        // Tentukan range halaman yang akan ditampilkan
        let startPage = Math.max(1, currentPage - displayRange);
        let endPage = Math.min(lastPage, currentPage + displayRange);

        // Tambahkan halaman pertama jika tidak termasuk dalam range
        if (startPage > 1) {
            items.push(table.paginationLink(1));
            if (startPage > 2) {
                items.push(table.paginationDots());
            }
        }

        // Generate halaman dalam range
        for (let i = startPage; i <= endPage; i++) {
            if (i === currentPage) {
                items.push(table.paginationCurrentPage(i));
            } else {
                items.push(table.paginationLink(i));
            }
        }

        // Tambahkan halaman terakhir jika tidak termasuk dalam range
        if (endPage < lastPage) {
            if (endPage < lastPage - 1) {
                items.push(table.paginationDots());
            }
            items.push(table.paginationLink(lastPage));
        }

        return items.join("");
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
        const currentSearch =
            document.querySelector("#search-name")?.value || "";
        const url = new URL(window.location.href);
        url.searchParams.set("page", page);
        if (currentSearch) {
            url.searchParams.set("search", currentSearch);
        }

        return `
            <a href="${url.search}"
                class="relative inline-flex items-center px-4 py-2 -ml-px text-xs md:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-gray-300"
                aria-label="Go to page ${page}"
            >
                ${page}
            </a>
        `;
    },

    paginationPrevButton: (currentPage) => {
        const currentSearch =
            document.querySelector("#search-name")?.value || "";
        const url = new URL(window.location.href);

        if (currentPage > 1) {
            url.searchParams.set("page", currentPage - 1);
            if (currentSearch) {
                url.searchParams.set("search", currentSearch);
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
        const currentSearch =
            document.querySelector("#search-name")?.value || "";
        const url = new URL(window.location.href);

        if (currentPage < lastPage) {
            url.searchParams.set("page", currentPage + 1);
            if (currentSearch) {
                url.searchParams.set("search", currentSearch);
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
    },
};
