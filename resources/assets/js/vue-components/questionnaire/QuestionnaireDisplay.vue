<template>
	<div id="questionnaire-display" class="component mt-3">
		<div v-if="filesUploading" id="questionnaire-files-loader-overlay"></div>
		<div v-if="filesUploading" id="questionnaire-files-loader" class="container-fluid">
			<div id="questionnaire-files-loader-row" class="row">
				<div class="col mb-4 text-center">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
				<div class="col-12 text-center">
					<p id="loader-message">Please wait. uploading files...</p>
				</div>
			</div>
		</div>
		<div v-if="displayLoginPrompt" class="container-fluid p-0">
			<div class="row mb-5 pt-3">
				<div class="col text-center">
					<h4 v-sane-html="getQuestionnaireLoginPromptMessage()" class="login-message"></h4>
				</div>
			</div>
			<div class="row justify-content-center d-none d-md-flex">
				<div class="col-5">
					<a class="btn btn-outline-primary btn-lg call-to-action w-100" :href="getSignInUrl()">{{
						trans("questionnaire.sign_in")
					}}</a>
				</div>
				<div v-if="!questionnaire.respondent_auth_required" class="col-5">
					<button class="btn btn-primary btn-lg call-to-action w-100" @click="skipLogin()">
						{{ trans("questionnaire.answer_anonymously") }}
					</button>
				</div>
			</div>
			<div class="row justify-content-center d-flex d-md-none">
				<div class="col-10">
					<a class="btn btn-outline-primary btn-lg call-to-action w-100" :href="getSignInUrl()">{{
						trans("questionnaire.sign_in")
					}}</a>
				</div>
				<div v-if="!questionnaire.respondent_auth_required" class="col-10">
					<button class="btn btn-primary btn-lg call-to-action w-100 my-4" @click="skipLogin()">
						{{ trans("questionnaire.answer_anonymously") }}
					</button>
				</div>
			</div>
		</div>
		<div v-else class="container-fluid p-0">
			<div v-if="!userResponse && !loading" class="row">
				<div class="col-md-12 language-selection">
					<div class="form-group">
						<label class="language-selector" for="language-select">{{
							trans("questionnaire.select_language")
						}}</label>
						<select id="language-select" class="form-control" @change="onLanguageChange($event)">
							<option
								v-for="(language, index) in surveyLocales"
								:key="index"
								:selected="language.code === defaultLangCode"
								:value="language.code"
							>
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
					<div :id="surveyContainerId" class="survey-container"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import * as Survey from "survey-jquery";
import { arrayMove, setCookie } from "../../common-utils";
import AnalyticsLogger from "../../analytics-logger";
import FingerprintJS from "@fingerprintjs/fingerprintjs";
import axios from "axios";

export default {
	name: "QuestionnaireDisplay",
	props: {
		user: {
			type: Object,
			default: () => ({}),
		},
		questionnaire: {
			type: Object,
			default: () => ({}),
		},
		project: {
			type: Object,
			default: () => ({}),
		},
		userResponseData: {
			type: Object,
			default: null,
		},
		surveyContainerId: {
			type: String,
			default: null,
		},
		languages: {
			type: Array,
			default: () => [],
		},
		moderator: {
			type: Boolean,
			default: false,
		},
		locale: {
			type: String,
			default: "en",
		},
	},
	data() {
		return {
			surveyCreator: null,
			survey: null,
			surveyLocales: [],
			userResponse: {},
			browserFingerprintId: null,
			questionnaireLocalStorageKey: `crowdsourcing_questionnaire_${this.questionnaire.id}_response`,
			displayLoginPrompt: false,
			loading: false,
			t0: null,
			defaultLangCode: "en",
			filesUploading: false,
		};
	},
	mounted() {
		this.onMounted();
	},
	methods: {
		async onMounted() {
			this.userResponse = this.userResponseData;
			this.loading = true;
			const fpPromise = FingerprintJS.load();
			this.browserFingerprintId = await fpPromise.then((fp) => fp.get()).then((result) => result.visitorId);
			this.displayLoginPrompt = !this.userLoggedIn() && !this.userResponse;
			if (!this.displayLoginPrompt) this.skipLogin();
			if (!this.userLoggedIn()) {
				if (this.browserFingerprintId) {
					const response = await this.getAnonymousUserResponse();
					this.userResponse = response?.data?.questionnaire_response ?? null;
				}
				this.displayLoginPrompt = !this.userResponse;
			}
			this.initQuestionnaireDisplay();
			this.loading = false;
		},
		userLoggedIn() {
			return this.user && this.user.id;
		},
		skipLogin() {
			this.displayLoginPrompt = false;
			this.loading = true;
			const surveyContainerId = this.surveyContainerId;
			const instance = this;
			setTimeout(() => {
				instance.survey.render(surveyContainerId);
			}, 2000);
		},
		getQuestionnaireLoginPromptMessage() {
			let message = "";
			if (this.questionnaire.respondent_auth_required) {
				message += trans("questionnaire.must_be_logged_in_prompt") + "<br><br>";
			}
			return message + trans("questionnaire.create_account_prompt");
		},
		initQuestionnaireDisplay() {
			Survey.StylesManager.applyTheme("modern");
			this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
			if (!this.userResponse || Object.keys(this.userResponse).length === 0) {
				this.prepareQuestionnaireForResponding();
			} else {
				this.prepareQuestionnaireForViewingResponse();
			}

			// Scroll to the top when the page changes
			this.survey.onCurrentPageChanged.add(() => {
				setTimeout(() => {
					const questionnaireDisplay = document.getElementById("questionnaire-display");
					if (questionnaireDisplay) {
						questionnaireDisplay.scrollIntoView({ behavior: "smooth", block: "start" });
					} else {
						console.error("Element #questionnaire-display not found for scrolling.");
					}
				}, 200); // Delay to ensure DOM updates
			});

			window.setInterval(() => {
				if ($(".sv-ranking--drag").length > 0) {
					$("body,#questionnaire-modal").addClass("disable-scroll");
				} else {
					$("body,#questionnaire-modal").removeClass("disable-scroll");
				}
			}, 300);
		},
		prepareQuestionnaireForResponding() {
			let locales = this.survey.getUsedLocales();
			if (!locales) {
				locales = ["en"];
			}
			this.defaultLangCode = this.getDefaultLocaleForQuestionnaire();
			arrayMove(locales, locales.indexOf(this.defaultLangCode), 0);
			for (let i = 0; i < locales.length; i++) {
				const locale = this.getLanguageFromCode(locales[i]);
				if (locale) {
					this.surveyLocales.push({
						code: locales[i],
						name: locale.language_name,
					});
				}
			}
			this.survey.onValueChanged.add(this.saveQuestionnaireResponseProgress);
			this.survey.onComplete.add(this.saveQuestionnaireResponse);
			this.survey.onUploadFiles.add(this.onUploadSurveyFile);
			// if the current locale exists in the survey locales, set it as the default locale
			if (this.surveyLocales.find((l) => l.code === this.locale)) {
				this.survey.locale = this.locale;
			} else if (this.surveyLocales && this.surveyLocales.length) {
				this.survey.locale = this.surveyLocales[0].code;
			}
			this.survey.onAfterRenderSurvey.add(() => {
				this.loading = false;

				setTimeout(() => {
					$("textarea").each(function () {
						$(this).attr("spellcheck", true);
					});
					$(".sv-components-container-contentBottom").after(
						"<p class='questionnaire-disclaimer d-block mb-0 px-1 text-center py-3'>" +
							trans("common.personal_information_disclaimer") +
							"</p>",
					);
				}, 2000);
			});
		},
		prepareQuestionnaireForViewingResponse() {
			this.survey.data = JSON.parse(this.userResponse.response_json);
			this.survey.mode = "display";
			const surveyContainerId = this.surveyContainerId;
			const instance = this;
			setTimeout(() => {
				instance.survey.render(surveyContainerId);
				instance.loading = false;
			}, 2000);
		},
		saveQuestionnaireResponseProgress(sender, options) {
			const responseJSON = window.localStorage.getItem(this.questionnaireLocalStorageKey);
			if (!responseJSON || !JSON.parse(responseJSON)) {
				AnalyticsLogger.logEvent(
					"user_engagement",
					`questionnaire_respond_begin_${this.questionnaire.default_fields_translation.title}`,
					"respond_begin",
					this.questionnaire.title,
					this.questionnaire.id,
				);
			}
			window.localStorage.setItem(this.questionnaireLocalStorageKey, JSON.stringify(sender.data));
			if (!this.t0) {
				this.t0 = performance.now();
			}
		},
		onUploadSurveyFile(sender, options) {
			if (options.files.length > 8) {
				return;
			}
			const data = new FormData();
			for (let i = 0; i < options.files.length; i++) {
				data.append(`files[${i}]`, options.files[i]);
			}
			data.append("project_id", this.project.id);
			data.append("questionnaire_id", this.questionnaire.id);
			const config = {
				headers: {
					"content-type": "multipart/form-data",
					Accept: "application/json",
				},
			};
			this.filesUploading = true;
			axios
				.post(window.route("api.files.upload"), data, config)
				.then((response) => {
					options.callback(
						"success",
						options.files.map((file) => ({
							file: file,
							content: response.data[file.name],
						})),
					);
				})
				.catch((err) => {
					console.error(err);
					options.callback("error");
				})
				.finally(() => {
					this.filesUploading = false;
				});
		},
		saveQuestionnaireResponse(sender) {
			const data = {};
			data.browser_fingerprint_id = this.browserFingerprintId;
			data.response = JSON.stringify(sender.data);
			data.moderator = this.moderator;
			let locale = sender.locale;
			if (!locale) {
				if (!this.surveyLocales || !this.surveyLocales.length) {
					locale = "en";
				} else {
					locale = this.surveyLocales[0].code;
				}
			}
			data.language_code = locale;
			this.postResponseDataAndShowResult(data);
		},
		postResponseDataAndShowResult(data) {
			this.$store
				.dispatch("post", {
					url: window.route("api.questionnaire-responses.store"),
					data: {
						...data,
						questionnaire_id: this.questionnaire.id,
						project_id: this.project.id,
					},
					urlRelative: false,
					handleError: false,
				})
				.then((response) => {
					const anonymousUserId = response.data.anonymousUserId;
					const responseId = response.data.responseId;
					if (anonymousUserId) {
						setCookie("crowdsourcing_anonymous_user_id", anonymousUserId, 3650);
					}
					const time = performance.now() - this.t0;
					const title = this.questionnaire.default_fields_translation.title;
					AnalyticsLogger.logEvent(
						"user_engagement",
						`questionnaire_respond_complete_${title}`,
						"respond_complete",
						JSON.stringify({
							questionnaire: title,
							project: this.project.default_translation.name,
							language: data.locale,
							time_to_complete: time,
						}),
						this.questionnaire.id,
					);
					window.localStorage.removeItem(this.questionnaireLocalStorageKey);
					this.displaySuccessResponse(anonymousUserId, responseId);
				})
				.catch((error) => {
					console.error(error);
					this.displayErrorResponse(error);
				})
				.finally(() => {
					window.$("#questionnaire-modal").modal("hide");
				});
		},
		displaySuccessResponse(anonymousUserId, responseId) {
			let questionnaireResponseThankYouURL = window.route(
				"questionnaire.thanks",
				this.locale,
				this.project.slug,
				this.questionnaire.id,
				responseId,
			);

			if (anonymousUserId) {
				questionnaireResponseThankYouURL += `?anonymous_user_id=${anonymousUserId}`;
			}

			if (this.moderator) {
				const separator = questionnaireResponseThankYouURL.includes("?") ? "&" : "?";
				questionnaireResponseThankYouURL += `${separator}is_moderator_view=true`;
			}

			$("#pyro").addClass("pyro-on");
			window.location = questionnaireResponseThankYouURL;
		},
		async displayErrorResponse(error) {
			const { default: swal } = await import("bootstrap-sweetalert");
			swal({
				title: "Oops!",
				text: `An error occurred: ${error.toString()}`,
				type: "error",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "OK",
			});
		},
		onLanguageChange(event) {
			// fix for the greek language (gr to el)
			if (event.target.value === "el") {
				event.target.value = "gr";
			}
			this.survey.locale = event.target.value;
		},
		getLanguageFromCode(code) {
			// fix for the greek language (gr to el)
			if (code === "gr") {
				code = "el";
			}
			return this.languages.find((l) => l.language_code === code);
		},
		getSignInUrl() {
			return window.route("login", this.locale) + `?redirectTo=${window.location.href}`;
		},
		getDefaultLocaleForQuestionnaire() {
			let locale = this.locale;
			// fix for the greek language (el to gr)
			if (locale === "el") {
				locale = "gr";
			}
			const locales = this.survey.getUsedLocales();
			// if the current locale exists in the survey locales, set it as the default locale
			if (locales && locales.length && locales.includes(locale)) {
				this.defaultLangCode = locale;
			} else if (locales && locales.length) {
				this.defaultLangCode = locales[0];
			}

			return this.defaultLangCode;
		},
		trans(key) {
			return window.trans(key);
		},
		async getAnonymousUserResponse() {
			try {
				return await axios.get(window.route("api.questionnaire.anonymous-responses.get"), {
					params: {
						browser_fingerprint_id: this.browserFingerprintId,
						questionnaire_id: this.questionnaire.id,
					},
				});
			} catch (error) {
				console.error(error);
			}
		},
	},
};
</script>

<style lang="scss">
@import "../../../sass/questionnaire/questionnaire-display";
</style>
