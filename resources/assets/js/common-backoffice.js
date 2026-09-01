import "datatables.net";
import "datatables.net-bs5";
import "datatables.net-buttons";
import "datatables.net-buttons-bs5";

import "datatables.net-responsive";
import "datatables.net-responsive-bs5";
import "datatables.net-select";
import "datatables.net-select-bs5";
import Clipboard from "clipboard/dist/clipboard";
import $ from "jquery";
import { showToast } from "./common-utils";
import { initBackofficeSidebar } from "./backoffice-sidebar";

(function () {
	const closeDismissibleAlerts = function () {
		setTimeout(function () {
			/* Close any flash message after some time*/
			window
				.$(".alert-dismissable, .alert-dismissible")
				.fadeTo(4000, 500)
				.slideUp(500, function () {
					window.bootstrap.Alert.getOrCreateInstance(this).close();
				});
		}, 5000);
	};

	const initClipboardElements = function () {
		const clipboard = new Clipboard(".copy-clipboard");

		clipboard.on("success", function (e) {
			showToast("Copied to clipboard!", "#28a745");
			e.clearSelection();
		});

		clipboard.on("error", function (e) {
			console.error(e);
			showToast(window.trans("common.copy_to_clipboard_error") + ": " + e.toString(), "#dc3545");
			e.clearSelection();
		});
	};

	const listenToReadMoreClicks = function () {
		const body = $("body");
		body.on("click", ".read-more", function () {
			$(this).siblings(".more-text").after('<a href="javascript:void(0);" class="read-less">Read less</a>');
			$(this).siblings(".more-text").removeClass("hidden");
			$(this).remove();
		});
		body.on("click", ".read-less", function () {
			$(this).siblings(".more-text").before('<a href="javascript:void(0);" class="read-more">Read more...</a>');
			$(this).siblings(".more-text").addClass("hidden");
			$(this).remove();
		});
	};

	const initializeTooltips = function () {
		document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
			window.bootstrap.Tooltip.getOrCreateInstance(el);
		});
	};

	$(document).ready(function () {
		initBackofficeSidebar();
		closeDismissibleAlerts();
		initClipboardElements();
		listenToReadMoreClicks();
		initializeTooltips();
	});
})();

export function isObject(obj) {
	return obj != null && obj.constructor.name === "Object";
}
