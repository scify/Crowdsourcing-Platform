
import ProblemsManagement from "../vue-components/loggedin-environment/management/crowd-sourcing-project/problem/ProblemsManagement.vue";
import { createApp } from "vue";
import store from "../store/store";

const app = createApp({
	components: {
		ProblemsManagement,
	},
});

app.use(store);
app.mount("#app");