/**
 * Utility Functions
 */
export const utils = {
    escapeHtml: (str) => {
        const div = document.createElement("div");
        div.textContent = str;
        return div.innerHTML;
    },

    truncateText: (text, length) => {
        if (!text) return "";
        return text.length > length ? text.substring(0, length) + "..." : text;
    },
};

/**
 * Debugging functions
 */
export const debug = {
    log: (section, data) => console.log(`[${section}]:`, data),
    error: (section, error) => console.error(`[${section} Error]:`, error),
};

/**
 * URL management functions
 */
export const urlManager = {
    /**
     * Retrieves current parameters from URL
     * @returns {Object} Object containing search and page parameters
     */
    getParams: () => {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            search: urlParams.get("search") || "",
            page: parseInt(urlParams.get("page")) || 1,
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
        window.history.pushState({}, "", url);
    },
};
