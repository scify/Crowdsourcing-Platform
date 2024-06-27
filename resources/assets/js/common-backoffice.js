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
			showToast("Error while copying to clipboard: " + e.toString(), "#dc3545");
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

	$(document).ready(function () {
		console.log("common-backoffice.js loaded");
		initializeIcheck();
		closeDismissibleAlerts();
		initClipboardElements();
		listenToReadMoreClicks();
		initializeTooltips();
	});
})();

export function isObject(obj) {
	return obj != null && obj.constructor.name === "Object";
}
