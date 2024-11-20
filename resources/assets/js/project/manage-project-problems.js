import ProblemsManagement from "../vue-components/backoffice/management/crowd-sourcing-project/problem/ProblemsManagement.vue";
import { createApp } from "vue";
import store from "../store/store";
import DOMPurify from "dompurify";

const app = createApp({
	components: {
		ProblemsManagement,
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
