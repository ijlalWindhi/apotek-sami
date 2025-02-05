import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";

// custom js
import { uiManager } from "./utility/ui-manager.js";
import { table } from "./utility/table.js";
import { utils, debug, urlManager } from "./utility/utils.js";
import { handleFetchError } from "./utility/handleFetchError.js";
import {
    SELECTORS,
    PriceCalculator,
    PriceHandler,
    UIManager,
    UtilsProduct,
    initEventListeners,
} from "./product.js";
import { priceCalculationsPO } from "./purchase-order.js";
import { productRecipeCalculations } from "./recipe.js";
import {
    priceCalculationsPOS,
    formatDatePrint,
    formattedDataTransaction,
    formattedDataSalesTransaction,
} from "./pos.js";
import { salesTransactionUtils } from "./salesTransaction.js";
import { returnUtils, priceCalculationsReturn } from "./return.js";
import Swal from "sweetalert2";

window.Alpine = Alpine;

// expose utility functions to the global scope
window.urlManager = urlManager;
window.debug = debug;
window.uiManager = uiManager;
window.utils = utils;
window.table = table;
window.handleFetchError = handleFetchError;
window.Swal = Swal;

// expose product related classes to the global scope
window.PriceCalculator = PriceCalculator;
window.PriceHandler = PriceHandler;
window.UIManager = UIManager;
window.initEventListeners = initEventListeners;
window.SELECTORS = SELECTORS;
window.UtilsProduct = UtilsProduct;

// expose purchase order related functions to the global scope
window.priceCalculationsPO = priceCalculationsPO;

// expose recipe related functions to the global scope
window.productRecipeCalculations = productRecipeCalculations;

// expose pos related functions to the global scope
window.priceCalculationsPOS = priceCalculationsPOS;
window.formatDatePrint = formatDatePrint;
window.formattedDataTransaction = formattedDataTransaction;
window.formattedDataSalesTransaction = formattedDataSalesTransaction;

// expose sales transaction related functions to the global scope
window.salesTransactionUtils = salesTransactionUtils;

// expose return related functions to the global scope
window.returnUtils = returnUtils;
window.priceCalculationsReturn = priceCalculationsReturn;

Alpine.start();
