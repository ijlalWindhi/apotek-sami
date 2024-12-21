import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";

// custom js
import { uiManager } from "./utility/ui-manager.js";
import { table } from "./utility/table.js";
import { utils, debug, urlManager } from "./utility/utils.js";
import { handleFetchError } from "./utility/handleFetchError.js";
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

Alpine.start();
