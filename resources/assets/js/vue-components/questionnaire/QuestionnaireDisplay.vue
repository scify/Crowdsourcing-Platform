<template>
  <div class="container-fluid">
    <div class="row" v-if="!userResponse">
      <div class="col-md-12">
        <div class="form-group">
          <label for="language-select">Select language</label>
          <select class="form-control" @change="onLanguageChange($event)" id="language-select">
            <option :selected="language.code === 'en'"
                    :value="language.code" v-for="(language, index) in surveyLocales"
                    :key="index">
              {{language.name}}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="survey-container">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import * as Survey from "survey-knockout";
import {arrayMove} from "../../common";

export default {
  created() {
  },
  mounted() {
    this.initQuestionnaireDisplay();
  },
  props: {
    questionnaire: {
      type: Object,
      default: function () {
        return {}
      }
    },
    project: {
      type: Object,
      default: function () {
        return {}
      }
    },
    userResponse: {
      type: Object,
      default: function () {
        return {}
      }
    },
    languages: []
  },
  data: function () {
    return {
      surveyCreator: null,
      survey: null,
      surveyLocales: []
    }
  },
  methods: {
    ...mapActions([
      'get',
      'handleError',
      'post'
    ]),
    initQuestionnaireDisplay() {
      Survey.StylesManager.applyTheme("modern");
      this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
      if (!this.userResponse)
        this.prepareQuestionnaireForResponding();
      else
        this.prepareQuestionnaireForViewingResponse();
      this.survey.render("survey-container");
    },
    prepareQuestionnaireForResponding() {
      this.survey.locale = 'en';
      const locales = this.survey.getUsedLocales();
      // show English as the first language
      arrayMove(locales, locales.indexOf("en"), 0);
      for (let i = 0; i < locales.length; i++) {
        const locale = this.getLanguageFromCode(locales[i]);
        if (locale)
          this.surveyLocales.push({
            code: locales[i],
            name: locale.language_name
          });
      }
      this.survey.onComplete.add(this.saveQuestionnaireResponse);
      this.survey
          .onAfterRenderSurvey
          .add(function () {
            $(".sv_complete_btn").after(
                "<p class='questionnaire-disclaimer'>Your personal information (email address) will never be publicly displayed.</p>"
            );
          });
    },
    prepareQuestionnaireForViewingResponse() {
      this.survey.data = JSON.parse(this.userResponse.response_json);
      this.survey.mode = 'display';
    },
    saveQuestionnaireResponse(sender) {
      const resultAsString = JSON.stringify(sender.data);
      $(".loader-wrapper").removeClass('hidden');
      $("#questionnaire-modal").modal('hide');
      this.post({
        url: route('respond-questionnaire'),
        data: {
          questionnaire_id: this.questionnaire.id,
          project_id: this.project.id,
          language_code: this.survey.locale,
          response: resultAsString
        },
        urlRelative: false,
        handleError: false
      }).then((response) => {
        this.displaySuccessResponse(response.data);
      }).catch(error => {
        console.error(error);
        this.displayErrorResponse(error);
      }).finally(() => {
        $("#questionnaire-modal").modal('hide');
      });
    },
    displaySuccessResponse(responseData) {
      $(".loader-wrapper").addClass('hidden');
      let questionnaireResponded = $("#questionnaire-responded");
      // add badge fetched from response to the appropriate container
      if (responseData.badgeHTML) {
        questionnaireResponded.find('.badge-container').html(responseData.badgeHTML);
        questionnaireResponded.modal({backdrop: 'static'});
        $("#pyro").addClass("pyro-on");
      }
    },
    displayErrorResponse(error) {
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
      })
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "~survey-jquery/modern.min.css";

#survey-container {
  .sv-btn.sv-footer__complete-btn, .sv-btn.sv-footer__next-btn, .sv-btn.sv-footer__prev-btn {
    background-color: $brand-primary;
    float: left;
    border-radius: 3px;
    font-size: 20px;
    font-weight: 500;
    line-height: 1.7em;
    border: 2px solid white;
  }

  .sv-page.sv-body__page, .sv-footer {
    margin-left: 0;
    margin-right: 0;
  }
}

</style>