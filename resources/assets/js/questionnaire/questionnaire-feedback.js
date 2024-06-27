import Vue from "vue";
import store from "../store/store";

import QuestionnaireDisplay from "../vue-components/questionnaire/QuestionnaireDisplay/QuestionnaireDisplay.vue";
import DOMPurify from "dompurify";

Vue.directive("sane-html", (el, binding) => {
	el.innerHTML = DOMPurify.sanitize(binding.value);
});

new Vue({
	el: "#app",
	store: store,
	components: {
		QuestionnaireDisplay,
	},
});
