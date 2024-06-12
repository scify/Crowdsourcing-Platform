import Vue from "vue";
import store from "../store/store";

import QuestionnaireCreateEdit from "../vue-components/questionnaire/QuestionnaireCreateEdit.vue";

new Vue({
	el: "#app",
	store: store,
	components: {
		QuestionnaireCreateEdit,
	},
});
