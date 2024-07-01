import { createApp } from "vue";
import store from "../store/store";

import QuestionnaireCreateEdit from "../vue-components/questionnaire/QuestionnaireCreateEdit.vue";
import DOMPurify from "dompurify";

const app = createApp({
	components: {
		QuestionnaireCreateEdit,
	},
});

// Register the "sane-html" directive globally
app.directive("sane-html", {
	updated(el, binding) {
		el.innerHTML = DOMPurify.sanitize(binding.value);
	},
	mounted(el, binding) {
		el.innerHTML = DOMPurify.sanitize(binding.value);
	},
});

app.use(store);
app.mount("#app");
