import Vue from "vue";
import store from "../store/store";

import QuestionnaireCreateEdit from "../vue-components/questionnaire/QuestionnaireCreateEdit.vue";
import DOMPurify from "dompurify";

Vue.directive("sane-html", (el, binding) => {
	el.innerHTML = DOMPurify.sanitize(binding.value);
});

new Vue({
	el: "#app",
	store: store,
	components: {
		QuestionnaireCreateEdit,
	},
});
