import { createApp } from "vue";
import store from "../store/store";
import CrowdSourcingProjectProblems from "../vue-components/crowdsourcing-project/problem/CrowdSourcingProjectProblems.vue";

import DOMPurify from "dompurify";

const app = createApp({
	components: {
		CrowdSourcingProjectProblems,
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