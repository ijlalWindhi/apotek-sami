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
    TabManager,
    UIManager,
    UtilsProduct,
    initEventListeners,
} from "./product.js";
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
window.TabManager = TabManager;
window.UIManager = UIManager;
window.initEventListeners = initEventListeners;
window.SELECTORS = SELECTORS;
window.UtilsProduct = UtilsProduct;

Alpine.start();
