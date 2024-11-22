import "icheck";

import "fastclick";
import "admin-lte/dist/js/adminlte.min"; // 'admin-lte/dist/js/app.min.js'

import "jquery-slimscroll";

import "datatables.net";
import "datatables.net-bs4";
import "datatables.net-buttons";
import "datatables.net-buttons-bs4";

import "datatables.net-responsive";
import "datatables.net-responsive-bs4";
import "datatables.net-select";
import "datatables.net-select-bs4";
import Clipboard from "clipboard/dist/clipboard";
import $ from "jquery";
import { showToast } from "./common-utils";

const MOBILE_WIDTH = 768;

(function () {
	const initializeIcheck = function () {
		$(".icheck-input").iCheck({
			checkboxClass: "icheckbox_square-blue",
			radioClass: "iradio_square-blue",
			increaseArea: "20%", // optional
		});
	};

	const closeDismissibleAlerts = function () {
		setTimeout(function () {
			/* Close any flash message after some time*/
			window
				.$(".alert-dismissable")
				.fadeTo(4000, 500)
				.slideUp(500, function () {
					window.$(".alert-dismissable").alert("close");
				});
		}, 3000);
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
		window.$('[data-toggle="tooltip"]').tooltip();
	};

	const toggleIconOnSidebarMenuToggle = function () {
		// if on mobile, set the icon to "fa-chevron-right" by default
		if (window.innerWidth < MOBILE_WIDTH) {
			$("#sidebar-menu-toggler").find("i").removeClass("fa-chevron-left").addClass("fa-chevron-right");
		}

		const toggler = $("#sidebar-menu-toggler");
		// on click, check if the button has an <i> element with a "fa-chevron-left" class.
		// If it does, then change it to "fa-chevron-right". Otherwise, change it to "fa-chevron-left".
		toggler.on("click", function () {
			// check if we are not in a mobile device
			if (window.innerWidth < MOBILE_WIDTH) {
				return;
			}

			const icon = toggler.find("i");
			if (icon.hasClass("fa-chevron-left")) {
				icon.removeClass("fa-chevron-left").addClass("fa-chevron-right");
			} else {
				icon.removeClass("fa-chevron-right").addClass("fa-chevron-left");
			}
		});
	};

	$(document).ready(function () {
		initializeIcheck();
		closeDismissibleAlerts();
		initClipboardElements();
		listenToReadMoreClicks();
		initializeTooltips();
		toggleIconOnSidebarMenuToggle();
	});
})();

export function isObject(obj) {
	return obj != null && obj.constructor.name === "Object";
}
