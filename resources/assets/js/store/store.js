import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import modal from './modal';
import Promise from "lodash/_Promise";


export default new Vuex.Store({
    strict: true,
    state: {
        modal,
        loading: false,
    },
    getters: {
        modal: state => {
            return state.modal;
        },
        loading: state => {
            return state.loading;
        },
    },

    mutations: {
        openModal() {
            this.state.modal.open = true;
        },
        closeModal() {
            this.state.modal.link = {};
            this.state.modal.open = false;
        },
        setLoading(state, status) {
            this.state.modal.link = {};
            this.state.loading = status;
            this.state.modal.loading = status;
        },
        setMessage(state, message) {
            this.state.modal.message = message;
        },
        setTitle(state, title) {
            this.state.modal.title = title;
        },
        setModalLink(state, link) {
            this.state.modal.link = link;
        },
        setModalAllowClose(state, status) {
            this.state.modal.allowClose = status;
        }
    },

    actions: {
        openModal: ({commit}) => {
            commit('openModal');
        },
        closeModal: ({commit}) => {
            commit('closeModal');
        },
        setLoading: ({commit}, status) => {
            commit('setLoading', status);
        },
        setMessage: ({commit}, message) => {
            commit('setMessage', message);
        },
        setTitle: ({commit}, title) => {
            commit('setTitle', title);
        },
        setModalLink: ({commit}, link) => {
            commit('setModalLink', link);
        },
        setModalAllowClose: ({commit}, status) => {
            commit('setModalAllowClose', status);
        },
        post: ({commit, dispatch}, {url, data, urlRelative = true, handleError = true}) => {
            commit('setLoading', true);
            url = urlRelative ? process.env.MIX_APP_URL + url : url;
            return new Promise(function callback(resolve, reject) {
                axios.post(url, data,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + process.env.MIX_API_AUTH_TOKEN
                        }
                    })
                    .then(function (response) {
                        if (response.status > 300) {
                            reject(response);
                            if (handleError)
                                dispatch('handleError', response);
                        } else {
                            commit('setLoading', false);
                            commit('closeModal');
                            resolve(response);
                        }
                    }).catch(function (error) {
                    if (handleError)
                        dispatch('handleError', error);
                    else
                        reject(error);
                });
            });
        },
        get: ({commit, dispatch}, {url, urlRelative = true, handleError = true}) => {
            commit('setLoading', true);
            url = urlRelative ? process.env.MIX_APP_URL + url : url;
            return new Promise(function callback(resolve, reject) {
                axios.get(url,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + process.env.MIX_API_AUTH_TOKEN
                        }
                    })
                    .then(function (response) {
                        if (response.status > 300) {
                            reject(response);
                            if (handleError)
                                dispatch('handleError', response);
                        } else {
                            commit('setLoading', false);
                            commit('closeModal');
                            resolve(response);
                        }
                    }).catch(function (error) {
                    if (handleError)
                        dispatch('handleError', error);
                    else
                        reject(error);
                });
            });
        },
        handleError: ({commit}, error) => {
            console.error(error);
            commit('setLoading', false);
            commit('openModal');
            commit('setModalAllowClose', true);
            if (error.response && error.response.data) {
                commit('setMessage', error.response.data.message !== "" ? error.response.data.message : error.response.statusText);
            } else if (error)
                commit('setMessage', error);
            else
                commit('setMessage', 'We are experiencing some difficulties' +
                    ' handling your request right now.<br>Please try again later.');
        },
    }

});
