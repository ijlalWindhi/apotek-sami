const paginationManager = {
    /**
     * Generate pagination HTML tanpa melakukan routing
     * @param {Object} meta - Metadata pagination
     * @param {number} meta.current_page - Halaman saat ini
     * @param {number} meta.last_page - Total halaman
     * @param {function} onPageChange - Callback ketika halaman berubah
     * @returns {string} HTML pagination
     */
    generatePagination: (meta, onPageChange) => {
        const currentPage = meta.current_page;
        const lastPage = meta.last_page;

        // Fungsi untuk membuat link halaman
        const createPageLink = (page) => {
            const link = document.createElement("a");
            link.href = "#";
            link.textContent = page;
            link.className =
                "relative inline-flex items-center px-4 py-2 -ml-px text-xs md:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500";

            // Tambahkan event listener untuk perubahan halaman
            link.addEventListener("click", (e) => {
                e.preventDefault();
                onPageChange(page);
            });

            return link;
        };

        // Fungsi untuk membuat kontainer pagination
        const createPaginationContainer = () => {
            const container = document.createElement("nav");
            container.setAttribute("role", "navigation");
            container.setAttribute("aria-label", "Pagination Navigation");
            container.className = "flex items-center justify-between";

            return container;
        };

        const paginationContainer = createPaginationContainer();
        const pageLinksContainer = document.createElement("div");
        pageLinksContainer.className = "flex";

        // Tombol Previous
        if (currentPage > 1) {
            const prevButton = createPageLink(currentPage - 1);
            prevButton.innerHTML = "&laquo; Previous";
            pageLinksContainer.appendChild(prevButton);
        }

        // Generate halaman
        const displayRange = 2;
        const startPage = Math.max(1, currentPage - displayRange);
        const endPage = Math.min(lastPage, currentPage + displayRange);

        // Tambahkan halaman pertama jika tidak termasuk dalam range
        if (startPage > 1) {
            pageLinksContainer.appendChild(createPageLink(1));
            if (startPage > 2) {
                const dotsSpan = document.createElement("span");
                dotsSpan.textContent = "...";
                dotsSpan.className = "px-4 py-2 text-gray-700";
                pageLinksContainer.appendChild(dotsSpan);
            }
        }

        // Generate halaman dalam range
        for (let i = startPage; i <= endPage; i++) {
            const pageLink = createPageLink(i);

            // Tandai halaman saat ini
            if (i === currentPage) {
                pageLink.classList.add("!bg-blue-600", "!text-white");
            }

            pageLinksContainer.appendChild(pageLink);
        }

        // Tambahkan halaman terakhir jika tidak termasuk dalam range
        if (endPage < lastPage) {
            if (endPage < lastPage - 1) {
                const dotsSpan = document.createElement("span");
                dotsSpan.textContent = "...";
                dotsSpan.className = "px-4 py-2 text-gray-700";
                pageLinksContainer.appendChild(dotsSpan);
            }
            pageLinksContainer.appendChild(createPageLink(lastPage));
        }

        // Tombol Next
        if (currentPage < lastPage) {
            const nextButton = createPageLink(currentPage + 1);
            nextButton.innerHTML = "Next &raquo;";
            pageLinksContainer.appendChild(nextButton);
        }

        paginationContainer.appendChild(pageLinksContainer);

        return paginationContainer;
    },

    /**
     * Update info data pagination
     * @param {Object} meta - Metadata pagination
     * @returns {string} Teks informasi data
     */
    generateDataInfo: (meta) => {
        return `Menampilkan ${meta.from || 0} ke ${meta.to || 0} dari ${
            meta.total || 0
        } total data`;
    },

    /**
     * Render pagination ke container yang ditentukan
     * @param {Object} meta - Metadata pagination
     * @param {HTMLElement} containerElement - Elemen tempat pagination akan dirender
     * @param {function} onPageChange - Callback ketika halaman berubah
     */
    renderPagination: (meta, containerElement, onPageChange) => {
        // Hapus konten sebelumnya
        containerElement.innerHTML = "";

        // Jika hanya satu halaman, sembunyikan pagination
        if (meta.last_page <= 1) {
            return;
        }

        const paginationElement = paginationManager.generatePagination(
            meta,
            onPageChange
        );
        containerElement.appendChild(paginationElement);
    },
};

/**
 * Handle response pagination
 * @param {Object} response - Response dari fetch
 * @param {function} fetchDataWithPagination - Fungsi untuk memuat data dengan pagination
 * @param {string} id_pagination - ID elemen pagination
 * @param {string} id_info - ID elemen informasi data
 * @returns {void}
 * @example
 * handleResponsePagination(
 *  response,
 *  fetchDataWithPagination,
 *  "pagination-container",
 *  "data-info",
 * );
 */
export function handleResponsePagination(
    response,
    fetchDataWithPagination,
    id_pagination,
    id_info
) {
    const paginationContainer = document.getElementById(id_pagination);
    const dataInfoContainer = document.getElementById(id_info);

    // Update informasi data
    dataInfoContainer.textContent = paginationManager.generateDataInfo(
        response.meta
    );

    // Render pagination
    paginationManager.renderPagination(
        response.meta,
        paginationContainer,
        (newPage) => {
            // Contoh: Memuat ulang data untuk halaman baru
            fetchDataWithPagination(newPage);
        }
    );
}
