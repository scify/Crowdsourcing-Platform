<template>
	<div class="component mt-3">
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
					<h3 v-sane-html="getQuestionnaireLoginPromptMessage()"></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-5 text-center pl-0 mx-auto">
					<a class="btn btn-outline-primary btn-lg w-100" :href="getSignInUrl()">{{
						trans("questionnaire.sign_in")
					}}</a>
				</div>
				<div v-if="!questionnaire.respondent_auth_required" class="col-5 offset-2 text-center pr-0">
					<button class="btn btn-primary btn-lg w-100" @click="skipLogin()">Answer anonymously</button>
				</div>
			</div>
		</div>
		<div v-else class="container-fluid">
			<div v-if="!userResponse" class="row">
				<div class="col-md-12 language-selection">
					<div class="form-group">
						<label for="language-select">{{ trans("questionnaire.select_language") }}</label>
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
import { onMounted, ref } from "vue";
import * as Survey from "survey-jquery";
import { arrayMove, setCookie } from "../../../common-utils";
import AnalyticsLogger from "../../../analytics-logger";
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
	},
	setup(props) {
		const surveyCreator = ref(null);
		const survey = ref(null);
		const surveyLocales = ref([]);
		const userResponse = ref({});
		const browserFingerprintId = ref(null);
		const questionnaireLocalStorageKey = ref(`crowdsourcing_questionnaire_${props.questionnaire.id}_response`);
		const displayLoginPrompt = ref(true);
		const loading = ref(false);
		const t0 = ref(null);
		const defaultLangCode = ref("en");
		const filesUploading = ref(false);

		onMounted(async () => {
			userResponse.value = props.userResponseData;
			const fpPromise = FingerprintJS.load();
			browserFingerprintId.value = await fpPromise.then((fp) => fp.get()).then((result) => result.visitorId);
			displayLoginPrompt.value = !userLoggedIn();
			if (!userLoggedIn()) {
				const response = await getAnonymousUserResponse();
				userResponse.value = response.data.questionnaire_response ?? null;
			}
			initQuestionnaireDisplay();
			if (!displayLoginPrompt.value) skipLogin();
		});

		const userLoggedIn = () => {
			return props.user && props.user.id;
		};

		const skipLogin = () => {
			displayLoginPrompt.value = false;
			const instance = this;
			loading.value = true;
			const surveyContainerId = props.surveyContainerId;
			setTimeout(() => {
				survey.value.render(surveyContainerId);
			}, 1000);
		};

		const getQuestionnaireLoginPromptMessage = () => {
			if (props.questionnaire.respondent_auth_required) {
				return "You must be logged in in order to respond to this questionnaire";
			}
			return "You can create an account in order to see more questionnaires that need answering";
		};

		const initQuestionnaireDisplay = () => {
			Survey.StylesManager.applyTheme("modern");
			survey.value = new Survey.Model(props.questionnaire.questionnaire_json);
			if (!userResponse.value || Object.keys(userResponse.value).length === 0) {
				prepareQuestionnaireForResponding();
			} else {
				prepareQuestionnaireForViewingResponse();
			}

			window.setInterval(() => {
				if ($(".sv-ranking--drag").length > 0) {
					$("body,#questionnaire-modal").addClass("disable-scroll");
				} else {
					$("body,#questionnaire-modal").removeClass("disable-scroll");
				}
			}, 300);
		};

		const prepareQuestionnaireForResponding = () => {
			const responseJSON = window.localStorage.getItem(questionnaireLocalStorageKey.value);
			if (responseJSON && JSON.parse(responseJSON)) {
				survey.value.data = JSON.parse(responseJSON);
			}
			let locales = survey.value.getUsedLocales();
			if (!locales) {
				locales = ["en"];
			}
			defaultLangCode.value = getDefaultLocaleForQuestionnaire();
			arrayMove(locales, locales.indexOf(defaultLangCode.value), 0);
			for (let i = 0; i < locales.length; i++) {
				const locale = getLanguageFromCode(locales[i]);
				if (locale) {
					surveyLocales.value.push({
						code: locales[i],
						name: locale.language_name,
					});
				}
			}
			survey.value.onValueChanged.add(saveQuestionnaireResponseProgress);
			survey.value.onComplete.add(saveQuestionnaireResponse);
			survey.value.onUploadFiles.add(onUploadSurveyFile);
			if (surveyLocales.value && surveyLocales.value.length) {
				survey.value.locale = surveyLocales.value[0].code;
			}
			const instance = this;
			survey.value.onAfterRenderSurvey.add(() => {
				loading.value = false;
				$(".sv_complete_btn").after(
					"<p class='questionnaire-disclaimer'>Your personal information (email address) will never be publicly displayed.</p>",
				);
				setTimeout(() => {
					$("textarea").each(function () {
						$(this).attr("spellcheck", true);
					});
				}, 3000);
			});
		};

		const prepareQuestionnaireForViewingResponse = () => {
			survey.value.data = JSON.parse(userResponse.value.response_json);
			survey.value.mode = "display";
		};

		const saveQuestionnaireResponseProgress = (sender, options) => {
			const responseJSON = window.localStorage.getItem(questionnaireLocalStorageKey.value);
			if (!responseJSON || !JSON.parse(responseJSON)) {
				AnalyticsLogger.logEvent(
					"user_engagement",
					`questionnaire_respond_begin_${props.questionnaire.default_fields_translation.title}`,
					"respond_begin",
					props.questionnaire.title,
					props.questionnaire.id,
				);
			}
			window.localStorage.setItem(questionnaireLocalStorageKey.value, JSON.stringify(sender.data));
			if (!t0.value) {
				t0.value = performance.now();
			}
		};

		const onUploadSurveyFile = (sender, options) => {
			if (options.files.length > 8) {
				return;
			}
			const data = new FormData();
			for (let i = 0; i < options.files.length; i++) {
				data.append(`files[${i}]`, options.files[i]);
			}
			data.append("project_id", props.project.id);
			data.append("questionnaire_id", props.questionnaire.id);
			const config = {
				headers: {
					"content-type": "multipart/form-data",
					Accept: "application/json",
				},
			};
			filesUploading.value = true;
			const instance = this;
			axios
				.post(window.route("files.upload"), data, config)
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
					filesUploading.value = false;
				});
		};

		const saveQuestionnaireResponse = (sender) => {
			const data = {};
			data.browser_fingerprint_id = browserFingerprintId.value;
			data.response = JSON.stringify(sender.data);
			data.moderator = props.moderator;
			let locale = sender.locale;
			if (!locale) {
				if (!surveyLocales.value || !surveyLocales.value.length) {
					locale = "en";
				} else {
					locale = surveyLocales.value[0].code;
				}
			}
			data.language_code = locale;
			$(".loader-wrapper").removeClass("hidden");
			window.$("#questionnaire-modal").modal("hide");
			$(".respond-questionnaire").attr("disabled", true);
			postResponseDataAndShowResult(data);
		};

		const postResponseDataAndShowResult = (data) => {
			post({
				url: window.route("respond-questionnaire"),
				data: {
					...data,
					questionnaire_id: props.questionnaire.id,
					project_id: props.project.id,
				},
				urlRelative: false,
				handleError: false,
			})
				.then((response) => {
					const anonymousUserId = response.data.anonymousUserId;
					if (anonymousUserId) {
						setCookie("crowdsourcing_anonymous_user_id", anonymousUserId, 3650);
					}
					const time = performance.now() - t0.value;
					const title = props.questionnaire.default_fields_translation.title;
					AnalyticsLogger.logEvent(
						"user_engagement",
						`questionnaire_respond_complete_${title}`,
						"respond_complete",
						JSON.stringify({
							questionnaire: title,
							project: props.project.default_translation.name,
							language: data.locale,
							time_to_complete: time,
						}),
						props.questionnaire.id,
					);
					window.localStorage.removeItem(questionnaireLocalStorageKey.value);
					displaySuccessResponse(anonymousUserId);
				})
				.catch((error) => {
					console.error(error);
					displayErrorResponse(error);
				})
				.finally(() => {
					window.$("#questionnaire-modal").modal("hide");
				});
		};

		const displaySuccessResponse = (anonymousUserId) => {
			if (props.moderator) {
				history.back();
			} else {
				let questionnaireResponseThankYouURL = window.route(
					"questionnaire.thanks",
					getDefaultLocaleForQuestionnaire(),
					props.project.slug,
					props.questionnaire.id,
				);
				if (anonymousUserId) {
					questionnaireResponseThankYouURL += `?anonymous_user_id=${anonymousUserId}`;
				}

				$("#pyro").addClass("pyro-on");
				window.location = questionnaireResponseThankYouURL;
			}
		};

		const displayErrorResponse = async (error) => {
			const { default: swal } = await import("bootstrap-sweetalert");
			swal({
				title: "Oops!",
				text: `An error occurred: ${error.toString()}`,
				type: "error",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "OK",
			});
		};

		const onLanguageChange = (event) => {
			survey.value.locale = event.target.value;
		};

		const getLanguageFromCode = (code) => {
			return props.languages.find((l) => l.language_code === code);
		};

		const getSignInUrl = () => {
			return window.route("login", getLocaleFromURL()) + `?redirectTo=${window.location.href}`;
		};

		const getDefaultLocaleForQuestionnaire = () => {
			const locales = survey.value.getUsedLocales();
			const url = window.location.href;
			const start = getPosition(url, "/", 3) + 1;
			const end = getPosition(url, "/", 4);
			const urlLang = url.substring(start, end);
			if (locales.indexOf(urlLang) !== -1) {
				return urlLang;
			}
			return defaultLangCode.value;
		};

		const getLocaleFromURL = () => {
			const url = window.location.href;
			const start = getPosition(url, "/", 3) + 1;
			const end = getPosition(url, "/", 4);
			return url.substring(start, end);
		};

		const getPosition = (str, subString, occurrence) => {
			return str.split(subString, occurrence).join(subString).length;
		};

		const trans = (key) => {
			return window.trans(key);
		};

		const getAnonymousUserResponse = async () => {
			return await get({
				url:
					window.route("questionnaire.response-anonymous") +
					`?browser_fingerprint_id=${browserFingerprintId.value}&questionnaire_id=${props.questionnaire.id}`,
				urlRelative: false,
			});
		};

		return {
			surveyCreator,
			survey,
			surveyLocales,
			userResponse,
			browserFingerprintId,
			questionnaireLocalStorageKey,
			displayLoginPrompt,
			loading,
			t0,
			defaultLangCode,
			filesUploading,
			skipLogin,
			getQuestionnaireLoginPromptMessage,
			onLanguageChange,
			getSignInUrl,
			trans,
		};
	},
};
</script>

<style lang="scss">
@import "../../../../sass/questionnaire/questionnaire-display";
</style>
