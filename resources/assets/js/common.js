window.wa = {};
window.wa.enums = {};
import "./lang";
import routeFunction from "./backend-route";

window.route = routeFunction;
import $ from "jquery";

window.$ = $;

import "./bootstrap";

import * as Sentry from "@sentry/browser";

if (import.meta.env.VITE_SENTRY_DSN_PUBLIC) {
	Sentry.init({
		dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
		// this is a temporary fix for the issue where the Google Recaptcha does
		// not properly reject errors. See https://github.com/getsentry/sentry-javascript/issues/2514#issuecomment-603971338
		beforeSend(event, hint) {
			if (hint.originalException === "Timeout") return null;
			return event;
		}
	});
}

(function () {
	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
		},
	});

	const handleLogoutBtnClick = function () {
		$(document).on("click", "#log-out", function (e) {
			e.preventDefault();
			$("#logout-form").submit();
		});
	};

	const trimTextareaInputFields = function () {
		// get all textarea elements
		// and trim their values
		$("textarea").each(function () {
			$(this).val($.trim($(this).val()));
		});
	};

	const init = function () {
		$(".dropdown-toggle").dropdown();
		handleLogoutBtnClick();
		$(".smooth-goto").on("click", function () {
			$("html, body").animate({ scrollTop: $(this.hash).offset().top - 100 }, 1000);
			return false;
		});
		trimTextareaInputFields();
	};

	$(document).ready(function () {
		init();
	});
})();
