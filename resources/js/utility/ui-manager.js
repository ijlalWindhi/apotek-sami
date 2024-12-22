/**
 * UI Management and Rendering
 */
export const uiManager = {
    /**
     * Refreshes all UI components
     * @param {Object} response - Server response containing data and meta information
     */
    refreshUI: (response) => {
        try {
            uiManager.updateTable(response.data);
            uiManager.updatePagination(response.meta);
            uiManager.updateInfo(response.meta);
        } catch (error) {
            debug.error("RefreshUI", error);
            uiManager.showError("Error updating display");
        }
    },

    /**
     * Updates the tax data table
     * @param {Array} data - Array of tax objects
     */
    updateTable: (data) => {
        debug.log("UpdateTable", "Starting table update");
        const tbody = $("#table-body");

        if (!Array.isArray(data) || data.length === 0) {
            tbody.html(table.emptyTable());
            return;
        }

        tbody.html(data.map((tax) => templates.tableRow(tax)).join(""));
        debug.log("UpdateTable", "Table updated successfully");
    },

    /**
     * Updates pagination controls
     * @param {Object} meta - Pagination metadata
     */
    updatePagination: (meta) => {
        const container = $(".pagination-container");

        if (!meta || meta.last_page <= 1) {
            container.hide();
            return;
        }

        container.show().html(table.pagination(meta));
    },

    /**
     * Updates data info text
     * @param {Object} meta - Pagination metadata
     */
    updateInfo: (meta) => {
        $(".data-info").html(table.dataInfo(meta));
    },

    /**
     * Shows loading state
     */
    showLoading: () => {
        $("#table-body").html(table.loading());
    },

    /**
     * Shows error message
     * @param {string} message - Error message to display
     */
    showError: (message) => {
        $("#table-body").html(table.error(message));
    },

    /**
     * Show loading modal
     */
    showLoadingModal: () => {
        return '<div class="z-20 absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90"><i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i></div>';
    },

    /**
     * Show screen loader
     */
    showScreenLoader: () => {
        return '<div class="z-20 fixed inset-0 flex items-center justify-center bg-white bg-opacity-90 dark:bg-gray-700 dark:bg-opacity-90"><i class="fa-solid fa-spinner animate-spin text-blue-700 dark:text-blue-600"></i></div>';
    },
};
