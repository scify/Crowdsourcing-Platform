import { createApp } from "vue";
import store from "../store/store";
import Problems from "../vue-components/problem/Problems.vue";

import DOMPurify from "dompurify";

const app = createApp({
	components: {
		Problems,
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
