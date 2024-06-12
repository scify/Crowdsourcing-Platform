import Vue from "vue";
import store from "../store/store";

import QuestionnaireDisplay from "../vue-components/questionnaire/QuestionnaireDisplay/QuestionnaireDisplay.vue";

new Vue({
	el: "#app",
	store: store,
	components: {
		QuestionnaireDisplay,
	},
});
