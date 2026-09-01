/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import $ from "jquery";

// jQuery 4 removed $.now; summernote 0.9.x still calls it during init.
// Remove this shim when summernote ships a jQuery 4-compatible release.
$.now = $.now || Date.now;

try {
	window.$ = window.jQuery = $;
} catch (e) {
	console.error(e);
}

import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

// Bootstrap 5 registers its jQuery plugin interfaces ($().tooltip() etc.) in
// a DOMContentLoaded listener. jQuery 4 runs ready callbacks before that
// listener, so plugins that summernote calls during init would not exist
// yet. Register them explicitly instead of relying on the timing.
for (const component of [bootstrap.Tooltip, bootstrap.Dropdown, bootstrap.Modal, bootstrap.Popover]) {
	const name = component.NAME;
	$.fn[name] = component.jQueryInterface;
	$.fn[name].Constructor = component;
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from "axios";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience, so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
	console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token");
}
