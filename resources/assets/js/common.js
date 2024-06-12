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

	let handleLogoutBtnClick = function () {
		$("#log-out").click(function (e) {
			e.preventDefault();
			$("#logout-form").submit();
		});
	};

	let init = function () {
		$(".dropdown-toggle").dropdown();
		handleLogoutBtnClick();
	};

	$(document).ready(function () {
		console.log("common.js loaded");
		init();
	});
})();
