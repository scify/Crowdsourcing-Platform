<template>
  <div class="component mt-3">
    <div v-if="displayLoginPrompt" class="container-fluid p-0">
      <div class="row mb-5 pt-3">
        <div class="col text-center">
          <h3 v-html="getQuestionnaireLoginPromptMessage()"></h3>
        </div>
      </div>
      <div class="row">
        <div class="col-5 text-center pl-0 mx-auto">
          <a class="btn btn-outline-primary btn-lg w-100" :href="getSignInUrl()">{{
              trans("questionnaire.sign_in")
            }}</a>
        </div>
        <div class="col-5 offset-2 text-center pr-0" v-if="!questionnaire.respondent_auth_required">
          <button @click="skipLogin()" class="btn btn-primary btn-lg w-100">Answer anonymously</button>
        </div>
      </div>
    </div>
    <div v-else class="container-fluid">
      <div class="row" v-if="!userResponse">
        <div class="col-md-12 language-selection">
          <div class="form-group">
            <label for="language-select">{{ trans("questionnaire.select_language") }}</label>
            <select class="form-control" @change="onLanguageChange($event)" id="language-select">
              <option :selected="language.code === defaultLangCode"
                      :value="language.code" v-for="(language, index) in surveyLocales"
                      :key="index">
                {{ language.name }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div v-if="loading" id="questionnaire-loader" class="row my-5">
        <div class="col text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div :id="surveyContainerId" class="survey-container">
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import {mapActions} from "vuex";
import * as Survey from "survey-knockout";
import {arrayMove, setCookie} from "../../../common-utils";
import AnalyticsLogger from "../../../analytics-logger";
import FingerprintJS from "@fingerprintjs/fingerprintjs";
import _ from "lodash";

export default {
	name: "QuestionnaireDisplay",
	props: {
		user: {
			type: Object,
			default: function () {
				return {};
			}
		},
		questionnaire: {
			type: Object,
			default: function () {
				return {};
			}
		},
		project: {
			type: Object,
			default: function () {
				return {};
			}
		},
		userResponseData: {
			type: Object,
			default: function () {
				return null;
			}
		},
		surveyContainerId: {
			type: String
		},
		languages: []
	},
	data: function () {
		return {
			surveyCreator: null,
			survey: null,
			surveyLocales: [],
			userResponse: {},
			browserFingerprintId: null,
			questionnaireLocalStorageKey: {
				type: String,
				default: "",
			},
			displayLoginPrompt: {
				type: Boolean,
				default: true,
			},
			loading: {
				type: Boolean,
				default: false,
			},
			t0: null,
			defaultLangCode: "en"
		};
	},
	created() {
		this.questionnaireLocalStorageKey = "crowdsourcing_questionnaire_" + this.questionnaire.id + "_response";
	},
	async mounted() {
		this.userResponse = this.userResponseData;
		const fpPromise = FingerprintJS.load();
		this.browserFingerprintId = await fpPromise
			.then(fp => fp.get())
			.then(result => result.visitorId);
		this.displayLoginPrompt = !this.userLoggedIn();
		if (!this.userLoggedIn()) {
			const response = await this.getAnonymousUserResponse();
			this.userResponse = response.data.questionnaire_response ?? null;
		}
		this.initQuestionnaireDisplay();
		if (!this.displayLoginPrompt)
			this.skipLogin();
	},
	methods: {
		...mapActions([
			"get",
			"handleError",
			"post"
		]),
		userLoggedIn() {
			return (this.user && this.user.id);
		},
		skipLogin() {
			this.displayLoginPrompt = false;
			const instance = this;
			this.loading = true;
			let surveyContainerId = this.$props.surveyContainerId;
			setTimeout(function () {
				instance.survey.render(surveyContainerId);
			}, 1000);
		},
		getQuestionnaireLoginPromptMessage() {
			if (this.questionnaire.respondent_auth_required)
				return "You must be logged in in order to respond to this questionnaire";
			return "You can create an account in order to see more questionnaires that need answering";
		},
		initQuestionnaireDisplay() {
			Survey.StylesManager.applyTheme("modern");
			this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
			if (_.isEmpty(this.userResponse))
				this.prepareQuestionnaireForResponding();
			else
				this.prepareQuestionnaireForViewingResponse();

			// bug fix on mobile browsers.
			// When you try to drag the rankings, the modal is scrolled, so you cannot complete it.
			// We should use a mutation observer instead of this.
			window.setInterval(function () {
				if ($(".sv-ranking--drag").length > 0) {
					$("body,#questionnaire-modal").addClass("disable-scroll");
				} else {
					$("body,#questionnaire-modal").removeClass("disable-scroll");
				}
			}, 300);
		},
		prepareQuestionnaireForResponding() {
			const responseJSON = window.localStorage.getItem(this.questionnaireLocalStorageKey);
			if (responseJSON && JSON.parse(responseJSON))
				this.survey.data = JSON.parse(responseJSON);
			let locales = this.survey.getUsedLocales();
			if (!locales)
				locales = ["en"];
			// set the default questionnaire language as first, in order to be loaded first.
			this.defaultLangCode = this.getDefaultLocaleForQuestionnaire();
			arrayMove(locales, locales.indexOf(this.defaultLangCode), 0);
			for (let i = 0; i < locales.length; i++) {
				const locale = this.getLanguageFromCode(locales[i]);
				if (locale)
					this.surveyLocales.push({
						code: locales[i],
						name: locale.language_name
					});
			}
			this.survey.onValueChanged.add(this.saveQuestionnaireResponseProgress);
			this.survey.onComplete.add(this.saveQuestionnaireResponse);
			this.survey.onUploadFiles.add(this.onUploadSurveyFile);
			this.survey.locale = this.surveyLocales[0].code;
			const instance = this;
			this.survey
				.onAfterRenderSurvey
				.add(function () {
					instance.loading = false;
					$(".sv_complete_btn").after(
						"<p class='questionnaire-disclaimer'>Your personal information (email address) will never be publicly displayed.</p>"
					);
					setTimeout(() => {
						$("textarea").each(function () {
							$(this).attr("spellcheck", true);
						});
					}, 3000);
				});
		},
		prepareQuestionnaireForViewingResponse() {
			this.survey.data = JSON.parse(this.userResponse.response_json);
			this.survey.mode = "display";
		},
		// eslint-disable-next-line no-unused-vars
		saveQuestionnaireResponseProgress(sender, options) {
			const responseJSON = window.localStorage.getItem(this.questionnaireLocalStorageKey);
			if (!responseJSON || !JSON.parse(responseJSON))
				AnalyticsLogger.logEvent("questionnaire_respond_begin_" + this.questionnaire.default_fields_translation.title, "respond_begin", this.questionnaire.title, this.questionnaire.id);
			window.localStorage.setItem(this.questionnaireLocalStorageKey, JSON.stringify(sender.data));
			if (!this.t0)
				this.t0 = performance.now();
		},
		onUploadSurveyFile(sender, options) {
			let data = new FormData();
			for (let i = 0; i < options.files.length; i++) {
				data.append("files[" + i + "]", options.files[i]);
			}
			const config = {
				headers: {
					"content-type": "multipart/form-data",
					"Accept": "application/json"
				}
			};
			axios.post(window.route("files.upload"), data, config)
				.then(function (response) {
					options.callback("success", options.files.map(file => {
						return {
							file: file,
							content: response.data[file.name]
						};
					}));
				})
				.catch(function (err) {
					console.error(err);
					options.callback("error");
				});
		},
		async saveQuestionnaireResponse(sender) {
			let data = {};
			data.browser_fingerprint_id = this.browserFingerprintId;
			data.response = JSON.stringify(sender.data);
			let locale = sender.locale;
			if (!locale)
				locale = this.surveyLocales[0].code;
			data.language_code = locale;
			$(".loader-wrapper").removeClass("hidden");
			$(".questionnaire-modal").modal("hide");
			$(".respond-questionnaire").attr("disabled", true);
			this.postResponseDataAndShowResult(data);
		},
		postResponseDataAndShowResult(data) {
			this.post({
				url: window.route("respond-questionnaire"),
				data: {
					...data,
					questionnaire_id: this.questionnaire.id,
					project_id: this.project.id,
				},
				urlRelative: false,
				handleError: false
			}).then((response) => {
				const anonymousUserId = response.data.anonymousUserId;
				if (anonymousUserId)
					setCookie("crowdsourcing_anonymous_user_id", anonymousUserId, 3650);
				const time = performance.now() - this.t0;
				const title = this.questionnaire.default_fields_translation.title;
				AnalyticsLogger.logEvent("questionnaire_respond_complete_" + title, "respond_complete", JSON.stringify({
					"questionnaire": title,
					"project": this.project.default_translation.name,
					"language": data.locale,
					"time_to_complete": time
				}), this.questionnaire.id);
				this.displaySuccessResponse(anonymousUserId);
			}).catch(error => {
				console.error(error);
				this.displayErrorResponse(error);
			}).finally(() => {
				$(".questionnaire-modal").modal("hide");
				window.localStorage.removeItem(this.questionnaireLocalStorageKey);
			});
		},
		displaySuccessResponse(anonymousUserId) {
			let questionnaireResponseThankYouURL = window.route("questionnaire.thanks", this.getDefaultLocaleForQuestionnaire(), this.project.slug, this.questionnaire.id);
			if (anonymousUserId)
				questionnaireResponseThankYouURL += ("?anonymous_user_id=" + anonymousUserId);

			$("#pyro").addClass("pyro-on");
			window.location = questionnaireResponseThankYouURL;
		},
		async displayErrorResponse(error) {
			const swal = (await import("bootstrap-sweetalert")).default;
			swal({
				title: "Oops!",
				text: "An error occurred:" + error.toString(),
				type: "error",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "OK",
			});
		},
		onLanguageChange(event) {
			this.survey.locale = event.target.value;
		},
		getLanguageFromCode(code) {
			return _.find(this.languages, function (l) {
				return l.language_code === code;
			});
		},
		getSignInUrl() {
			return window.route("login", this.getLocaleFromURL()) + "?redirectTo=" + window.location.href;
		},
		getDefaultLocaleForQuestionnaire() {
			const locales = this.survey.getUsedLocales();
			// the lang in URl is between the 3rd and the 4rth slash characters
			const url = window.location.href;
			const start = this.getPosition(url, "/", 3) + 1;
			const end = this.getPosition(url, "/", 4);
			const urlLang = url.substring(start, end);
			if (locales.indexOf(urlLang) !== -1)
				return urlLang;
			return this.defaultLangCode;
		},
		getLocaleFromURL() {
			const url = window.location.href;
			const start = this.getPosition(url, "/", 3) + 1;
			const end = this.getPosition(url, "/", 4);
			return url.substring(start, end);
		},
		getPosition(string, subString, occurrence) {
			return string.split(subString, occurrence).join(subString).length;
		},
		trans(key) {
			return window.trans(key);
		},
		async getAnonymousUserResponse() {
			return await this.get({
				url: window.route("questionnaire.response-anonymous") + "?browser_fingerprint_id=" + this.browserFingerprintId + "&questionnaire_id=" + this.questionnaire.id,
				urlRelative: false
			});
		}
	}
};
</script>

<style lang="scss">
@import "QuestionnaireDisplay";
</style>