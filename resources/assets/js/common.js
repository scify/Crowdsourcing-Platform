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
	});
}

(function () {
	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
		},
	});

	const handleLogoutBtnClick = function () {
		$("#log-out").click(function (e) {
			e.preventDefault();
			$("#logout-form").submit();
		});
	};

	const init = function () {
		$(".dropdown-toggle").dropdown();
		handleLogoutBtnClick();
		$(".smooth-goto").on("click", function () {
			$("html, body").animate({ scrollTop: $(this.hash).offset().top - 100 }, 1000);
			return false;
		});
	};

	$(document).ready(function () {
		init();
	});
})();
