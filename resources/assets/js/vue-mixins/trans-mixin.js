// resources/assets/js/mixins/transMixin.js
export default {
	methods: {
		trans(key, replace = {}) {
			return window.trans(key, replace);
		}
	}
};