window.wa = {};
window.wa.enums = {};
window.swal = import("bootstrap-sweetalert");
import "./lang";
import route from "./backend-route";

window.route = route;

import "./bootstrap";

import Vue from "vue";
import store from "./store/store";

import QuestionnaireCreateEdit from "./vue-components/questionnaire/QuestionnaireCreateEdit";
import QuestionnaireDisplay from "./vue-components/questionnaire/QuestionnaireDisplay/QuestionnaireDisplay";
import QuestionnaireStatistics from "./vue-components/questionnaire/QuestionnaireStatistics";
import CrowdSourcingProjectColors from "./vue-components/crowd-sourcing-project/CrowdSourcingProjectColors";
import TranslationsManager from "./vue-components/common/TranslationsManager";

new Vue({
	el: "#app",
	store: store,
	components: {
		QuestionnaireCreateEdit,
		QuestionnaireDisplay,
		QuestionnaireStatistics,
		CrowdSourcingProjectColors,
		TranslationsManager
	}
});

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