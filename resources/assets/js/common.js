window.wa = {};
window.wa.enums = {};
import "./lang";
import route from "./backend-route";

window.route = route;

import "./bootstrap";

(function () {

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
		}
	});

	let handleLogoutBtnClick = function () {
		$("#log-out").click(function (e) {
			e.preventDefault();
			$("#logout-form").submit();
		});
	};

	let init = function () {
		handleLogoutBtnClick();
	};

	$(document).ready(function () {
		init();
	});

})();