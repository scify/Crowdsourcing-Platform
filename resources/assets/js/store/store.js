import { createStore } from "vuex";
import axios from "axios";

// Import your modules if you have any
import modal from "./modal";

export default createStore({
	strict: true,
	state: {
		modal: modal,
		loading: false,
	},
	getters: {
		modal: (state) => state.modal,
		loading: (state) => state.loading,
	},
	mutations: {
		openModal(state) {
			state.modal.open = true;
		},
		closeModal(state) {
			state.modal.link = {};
			state.modal.open = false;
		},
		setLoading(state, status) {
			state.modal.link = {};
			state.loading = status;
			state.modal.loading = status;
		},
		setMessage(state, message) {
			state.modal.message = message;
		},
		setTitle(state, title) {
			state.modal.title = title;
		},
		setModalLink(state, link) {
			state.modal.link = link;
		},
		setModalAllowClose(state, status) {
			state.modal.allowClose = status;
		},
	},
	actions: {
		openModal({ commit }) {
			commit("openModal");
		},
		closeModal({ commit }) {
			commit("closeModal");
		},
		setLoading({ commit }, status) {
			commit("setLoading", status);
		},
		setMessage({ commit }, message) {
			commit("setMessage", message);
		},
		setTitle({ commit }, title) {
			commit("setTitle", title);
		},
		setModalLink({ commit }, link) {
			commit("setModalLink", link);
		},
		setModalAllowClose({ commit }, status) {
			commit("setModalAllowClose", status);
		},
		async post({ commit, dispatch }, { url, data, urlRelative = true, handleError = true }) {
			commit("setLoading", true);
			url = urlRelative ? import.meta.env.VITE_APP_URL + url : url;
			data = {
				...data,
				lang: document.documentElement.lang,
			};
			try {
				const response = await axios.post(url, data, {
					headers: {
						Accept: "application/json",
					},
				});
				if (response.status > 300) {
					throw response;
				}
				commit("setLoading", false);
				commit("closeModal");
				return response;
			} catch (error) {
				if (handleError) {
					dispatch("handleError", error);
				} else {
					throw error;
				}
			}
		},
		async get({ commit, dispatch }, { url, urlRelative = true, handleError = true }) {
			commit("setLoading", true);
			url = urlRelative ? import.meta.env.VITE_APP_URL + url : url;
			try {
				const response = await axios.get(url, {
					headers: {
						Accept: "application/json",
					},
				});
				if (response.status > 300) {
					throw response;
				}
				commit("setLoading", false);
				commit("closeModal");
				return response;
			} catch (error) {
				if (handleError) {
					dispatch("handleError", error);
				} else {
					throw error;
				}
			}
		},
		handleError({ commit }, error) {
			console.error(error);
			commit("setLoading", false);
			commit("openModal");
			commit("setModalAllowClose", true);
			if (error.response && error.response.data) {
				commit(
					"setMessage",
					error.response.data.message !== "" ? error.response.data.message : error.response.statusText,
				);
			} else if (error) {
				commit("setMessage", error);
			} else {
				commit(
					"setMessage",
					"We are experiencing some difficulties handling your request right now.<br>Please try again later.",
				);
			}
		},
	},
});
