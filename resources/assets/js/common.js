window.wa = {};
window.wa.enums = {};
window.swal = import("bootstrap-sweetalert");
import route from "./backend-route";

window.route = route;

import "./bootstrap";

import Vue from "vue";
import store from "./store/store";

Vue.component("common-modal", require("./vue-components/common/ModalComponent").default);
Vue.component("store-modal", require("./vue-components/common/StoreModalComponent").default);
Vue.component("questionnaire-create-edit", require("./vue-components/questionnaire/QuestionnaireCreateEdit").default);
Vue.component("questionnaire-languages", require("./vue-components/questionnaire/QuestionnaireLanguages").default);
Vue.component("questionnaire-display", require("./vue-components/questionnaire/QuestionnaireDisplay").default);
Vue.component("questionnaire-statistics", require("./vue-components/questionnaire/QuestionnaireStatistics").default);
Vue.component("crowd-sourcing-project-colors", require("./vue-components/crowd-sourcing-project/CrowdSourcingProjectColors").default);
Vue.component("translations-manager", require("./vue-components/common/TranslationsManager").default);

new Vue({
	el: "#app",
	store: store
});

axios.get("/" + window.Laravel.locale + "/app-translations",
	{
		headers: {
			"Accept": "application/json"
		}
	})
	.then(function (response) {
		window.translations = response.data.translations;
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