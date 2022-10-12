<template>
  <div class="component mt-3">
    <div v-if="displayLoginPrompt" class="container-fluid p-0">
      <div class="row mb-5">
        <h3>You can create an account in order to see more questionnaires that need answering</h3>
      </div>
      <div class="row">
        <div class="col-5 text-center pl-0">
          <a class="btn btn-outline-primary btn-lg w-100" :href="getSignInUrl()">Sign in</a>
        </div>
        <div class="col-5 offset-2 text-center pr-0">
          <button @click="skipLogin()" class="btn btn-primary btn-lg w-100">Answer anonymously</button>
        </div>
      </div>
    </div>
    <div v-else class="container-fluid">
      <div class="row" v-if="!userResponse">
        <div class="col-md-12 language-selection">
          <div class="form-group">
            <label for="language-select">{{ trans('questionnaire.select_language') }}</label>
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
import {arrayMove, setCookie} from "../../common-utils";
import AnalyticsLogger from "../../analytics-logger";

export default {
	created() {
		this.questionnaireLocalStorageKey = "crowdsourcing_questionnaire_" + this.questionnaire.id + "_response";
	},
	mounted() {
		this.initQuestionnaireDisplay();
		//this.displayLoginPrompt = !(this.user && this.user.id);
		this.displayLoginPrompt = false;
		if (!this.displayLoginPrompt)
			this.skipLogin();
	},
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
		userResponse: {
			type: Object,
			default: function () {
				return {};
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
			questionnaireLocalStorageKey: "",
			displayLoginPrompt: true,
			loading: false,
			t0: null,
			defaultLangCode: "en"
		};
	},
	methods: {
		...mapActions([
			"get",
			"handleError",
			"post"
		]),
		skipLogin() {
			this.displayLoginPrompt = false;
			const instance = this;
			this.loading = true;
			let surveyContainerId = this.$props.surveyContainerId;
			setTimeout(function () {
				instance.survey.render(surveyContainerId);
			}, 500);
		},
		initQuestionnaireDisplay() {
			Survey.StylesManager.applyTheme("modern");
			this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
			if (!this.userResponse)
				this.prepareQuestionnaireForResponding();
			else
				this.prepareQuestionnaireForViewingResponse();

			//bug fix on mobile browsers.
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
			const locales = this.survey.getUsedLocales();
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
		saveQuestionnaireResponse(sender) {
			let locale = sender.locale;
			if (!locale)
				locale = this.surveyLocales[0].code;

			const resultAsString = JSON.stringify(sender.data);
			$(".loader-wrapper").removeClass("hidden");
			$(".questionnaire-modal").modal("hide");
			$(".respond-questionnaire").attr("disabled", true);
			this.post({
				url: window.route("respond-questionnaire"),
				data: {
					questionnaire_id: this.questionnaire.id,
					project_id: this.project.id,
					language_code: locale,
					response: resultAsString
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
					"language": locale,
					"time_to_complete": time
				}), this.questionnaire.id);
				this.displaySuccessResponse(anonymousUserId);
			}).catch(error => {
				console.error(error);
				this.displayErrorResponse(error);
			}).finally(() => {
				$(".questionnaire-modal").modal("hide");
			});
		},
		displaySuccessResponse(anonymousUserId) {
			let questionnaireResponseThankYouURL = window.route("questionnaire.thanks", this.getDefaultLocaleForQuestionnaire(), this.project.slug, this.questionnaire.id);
			if (anonymousUserId)
				questionnaireResponseThankYouURL += ("?anonymous_user_id=" + anonymousUserId);

			$("#pyro").addClass("pyro-on");
			window.location = questionnaireResponseThankYouURL;
		},
		displayErrorResponse(error) {
			window.swal({
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
			const keys = key.split(".");
			if (!window.language[window.Laravel.locale])
				return "Language";
			return window.language[window.Laravel.locale][keys[0]][keys[1]];
		}
	}
};
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "~survey-jquery/modern.min.css";

.survey-container {
  .sv-btn.sv-footer__complete-btn, .sv-btn.sv-footer__next-btn, .sv-btn.sv-footer__prev-btn, .sv-btn.sv-footer__start-btn {
    background-color: $brand-primary;
    border-radius: 3px;
    font-size: 20px;
    font-weight: 500;
    line-height: 1.7em;
    border: 2px solid white;
  }

  .sv-btn.sv-footer__prev-btn {
    float: left;
  }

  .sv-btn.sv-footer__complete-btn, .sv-btn.sv-footer__next-btn, .sv-btn.sv-footer__start-btn {
    float: right;
  }

  .sv-page.sv-body__page, .sv-footer {
    margin-left: 0;
    margin-right: 0;
  }

  .sv-root-modern .sv-question__title--answer {
    background-color: rgba(0, 119, 255, 0.2);
  }

  .sv-root-modern .sv-rating__item--selected .sv-rating__item-text {
    background-color: $brand-primary;
    color: rgb(255, 255, 255);
    border-color: $brand-primary;
  }

  .sv-root-modern .sv-checkbox--checked .sv-checkbox__svg {
    background-color: $brand-primary;
  }

  .sv-root-modern ::-webkit-scrollbar-thumb {
    background: $brand-primary;
  }
}


#questionnaire-loader {
  .spinner-border {
    width: 5rem;
    height: 5rem;
    border-width: 0.5rem;
    border-color: $brand-primary;
    border-right-color: transparent;
  }
}


.disable-scroll {
  overflow-y: hidden !important;
}


</style>
