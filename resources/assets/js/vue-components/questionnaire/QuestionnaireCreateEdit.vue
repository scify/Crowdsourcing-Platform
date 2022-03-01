<template>
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="card card-primary">
        <div class="card-header">
          Questionnaire Info
        </div>
        <div class="card-body">

          <div class="row" v-if="questionnaire.id">
            <div class="col-md-12">
              <div class="warning-wrapper">
                <i class="glyphicon glyphicon-alert"></i>
                Please notice, that if you click on the button "Save" below, your questionnaire's
                translations will not be synchronized with the latest questionnaire's changes. You
                need to revisit the translations to make sure that it will be correctly displayed
                in different languages.
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="language">Projects the Questionnaire belongs to</label>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12">
              <select
                  id="project-ids" class="select2" multiple="multiple">
                <option v-for="project in projects"
                        :value="project.id"
                        :selected="isProjectSelected(project.id)">
                  {{ project.default_translation.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="language">Type</label>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12">
              <select
                  id="questionnaire-types" v-model="questionnaire.type_id">
                <option value="1">Main Questionnaire | The questionnaire the users are asked to respond for a project
                </option>
                <option value="2">Feedback Questionnaire | The quality assessment questionnaire. User are invited to
                  respond after they have responded to the Main questionnaire
                </option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="language">Statistics page visibility</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <select name="statistics_page_visibility_lkp_id" id="statistics_page_visibility_lkp_id">
                <option v-for="visibilityLkp in questionnaireStatisticsPageVisibilityLkp"
                        :value="visibilityLkp.id"
                        v-model="questionnaire.statistics_page_visibility_lkp_id"
                        :selected="questionnaire.statistics_page_visibility_lkp_id === visibilityLkp.id">
                  {{ visibilityLkp.title }}
                </option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="title">Questionnaire's Title</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="text" class="form-control" name="title" id="title"
                     placeholder="Insert questionnaire's title"
                     v-model="questionnaire.default_fields_translation.title">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label>Description</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="description" id="description"
                                      v-model="questionnaire.default_fields_translation.description"
                                      placeholder="Insert questionnaire's description">
                            </textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="goal">Responses Goal</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="number" class="form-control" name="goal" id="goal"
                     required
                     placeholder="Insert questionnaire's goal"
                     v-model="questionnaire.goal">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="goal">Max number of votes (statistics page)</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="number" class="form-control" name="max_votes_num" id="max_votes_num"
                     required
                     v-model="questionnaire.max_votes_num">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="goal">Show general statistics</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="checkbox" class="form-control checkbox" name="show_general_statistics"
                     id="show_general_statistics"
                     v-model="questionnaire.show_general_statistics">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label>Other translations</label>
            </div>
            <div class="col-md-10 col-sm-6 col-xs-12">
              <translations-manager
                  :model-meta-data='translationMetaData'
                  :default-lang-id='questionnaire.default_language_id'
                  :existing-translations='questionnaireFieldsTranslations'
              />
            </div>

          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label>Default Language</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <select
                  class="language-select"
                  @change="initQuestionnaireEditor($event.target.value)"
                  id="language">
                <option v-for="language in languages"
                        :value="language.language_code"
                        :selected="shouldLanguageBeSelected(language)">
                  {{ language.language_name }}
                </option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 editor-wrapper">
              <em>Use the editor below to create your questionnaire.</em>
              <div id="questionnaire-editor"></div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-offset-10 col-md-2">
              <button @click="saveQuestionnaire" class="btn btn-block btn-primary btn-lg w-100">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-component">
      <modal
          :hide-header="true"
          :open="modalOpen"
          :allow-close="false">
        <template v-slot:body>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-10 text-center mx-auto">
                                        <span
                                            class="loader loader-lg loader-dark spinner-border my-5"
                                            role="status"
                                            aria-hidden="true"></span>
                <h4 v-if="modalMessage" class="mt-0 p-0 mb-5 text-center message" v-html="modalMessage"></h4>
              </div>
            </div>
          </div>
        </template>
      </modal>
    </div>
    <questionnaire-languages
        :questionnaire-id="questionnaire.id"
        :modal-open="questionnaireLanguagesModalOpen"
        @canceled="questionnaireLanguagesModalOpen = false"
    ></questionnaire-languages>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import * as Survey from "survey-knockout";
import * as SurveyCreator from "survey-creator";
import _ from "lodash";
import {arrayMove, showToast} from "../../common-utils";

export default {
  created() {
    this.questionnaire = this.questionnaireData;

    if (!this.questionnaire.project_id)
      this.questionnaire.project_id = this.projects[0].id;
    if (!this.questionnaire.statistics_page_visibility_lkp_id)
      this.questionnaire.statistics_page_visibility_lkp_id = this.questionnaireStatisticsPageVisibilityLkp[0].id
    this.questionnaire.projectIds = _.map(this.questionnaireData.projects, 'id');
    if (this.questionnaire.default_language_id) {
      const langId = this.questionnaire.default_language_id;
      this.defaultLocale = this.languages.filter(function (el) {
        return el.id === langId;
      })[0].language_code;
    } else {
      const instance = this;
      this.defaultLocale = this.languages.filter(function (el) {
        return el.language_code === instance.defaultLangCodeForQuestionnaireFields;
      })[0].language_code;
    }
  },
  mounted() {
    if (this.questionnaire.project_id)
      this.getColorsForCrowdSourcingProject();
  },
  props: {
    questionnaireData: {
      type: Object,
      default: function () {
        return {}
      }
    },
    projects: [],
    languages: [],
    questionnaireStatisticsPageVisibilityLkp: [],
    translationMetaData: [],
    questionnaireFieldsTranslations: []
  },
  data: function () {
    return {
      questionnaire: {
        title: null,
        default_language_id: null,
        prerequisite_order: null,
        description: null,
        goal: null,
        statistics_page_visibility_lkp_id: null,
        projectIds: [],
        type_id: 1
      },
      surveyCreator: null,
      questionTypes: ["boolean", "checkbox", "comment", "dropdown",
        "html", "matrix", "matrixdropdown", "radiogroup", "rating", "text", "ranking"],
      colors: [],
      isTranTabInitialised: false,
      modalOpen: false,
      modalMessage: null,
      defaultLocale: null,
      questionnaireLanguagesModalOpen: false,
      defaultLangCodeForQuestionnaireFields: 'en'
    }
  },
  methods: {
    ...mapActions([
      'get',
      'handleError',
      'post'
    ]),
    isProjectSelected(projectId) {
      return this.questionnaire.projectIds.includes(projectId);
    },
    shouldLanguageBeSelected(language) {
      if (this.questionnaire.default_language_id)
        return this.questionnaire.default_language_id === language.id;
      return language.language_code === this.defaultLangCodeForQuestionnaireFields;
    },
    getColorsForCrowdSourcingProject() {
      this.get({
        url: route('crowd-sourcing-project.get-colors', this.questionnaire.project_id),
        data: {},
        urlRelative: false
      }).then(response => {
        this.colors = _.map(response.data, 'color_name').sort();
        this.initQuestionnaireEditor(this.defaultLocale);
      });
    },
    initQuestionnaireEditor(locale) {
      this.questionnaire.default_language_id = this.languages.filter(function (el) {
        return el.language_code === locale;
      })[0].id;

      this.initLocaleForQuestionnaireEditor(locale);

      Survey
          .JsonObject
          .metaData
          .addProperty("itemvalue", {
            name: "statsColor",
            title: "Stats Color",
            choices: this.colors,
            isRequired: false
          });

      const options = {
        // show the embedded survey tab. It is hidden by default
        showEmbeddedSurveyTab: false,
        // hide the test survey tab. It is shown by default
        showTestSurveyTab: true,
        // hide the JSON text editor tab. It is shown by default
        showJSONEditorTab: true,
        showTranslationTab: true,
        questionTypes: this.questionTypes
      };

      this.surveyCreator = new SurveyCreator.SurveyCreator(null, options);
      this.surveyCreator.render("questionnaire-editor");
      this.surveyCreator.haveCommercialLicense = true;


      if (this.questionnaireData.questionnaire_json)
        this.surveyCreator.text = this.assignRandomColorsToChoices(this.questionnaireData.questionnaire_json);
      let instance = this;
      let usedLocales = new Survey.Model(this.surveyCreator.text).getUsedLocales();

      if (!this.isTranTabInitialised) {
        if (usedLocales.length)
          this.surveyCreator.translation.setSelectedLocales(usedLocales);
        this.isTranTabInitialised = true;
        this.surveyCreator.translation.mergeLocaleWithDefault();
        this.surveyCreator.translation.toolbarItems.push({
          id: "auto-translate",
          visible: true,
          title: "Translate Survey Now",
          action: function () {
            instance.translateQuestionnaireToLocales(instance.surveyCreator.translation.getSelectedLocales());
          }
        });
        if (this.questionnaire.id)
          this.surveyCreator.translation.toolbarItems.push({
            id: "questionnaire-languages",
            visible: true,
            title: "Mark languages as approved",
            action: function () {
              instance.questionnaireLanguagesModalOpen = true;
            }
          });
      }

    },
    initLocaleForQuestionnaireEditor(locale) {
      this.defaultLocale = locale;
      // show default language as the first language
      arrayMove(this.languages, this.getIndexOfDefaultLocale(), 0);
      Survey.surveyLocalization.supportedLocales = _.map(this.languages, 'language_code');
      Survey.surveyLocalization.defaultLocale = this.defaultLocale;
      SurveyCreator.editorLocalization.currentLocale = this.defaultLocale;
      for (let i = 0; i < this.languages.length; i++)
        Survey.surveyLocalization.localeNames[this.languages[i].language_code] = this.languages[i].language_name;
    },
    getIndexOfDefaultLocale() {
      for (let i = 0; i < this.languages.length; i++)
        if (this.languages[i].language_code === this.defaultLocale)
          return i;
      throw "Default locale not found";
    },
    translateQuestionnaireToLocales(locales) {
      locales = locales.filter(function (el) {
        return el !== "";
      });
      if (!locales.length)
        return swal({
          title: "Languages Missing!",
          text: "Please provide at least one language from the dropdown menu.",
          type: "warning",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "OK",
        });
      this.modalOpen = true;
      this.modalMessage = 'Please wait while the translations are generated...';
      const data = {
        questionnaire_json: this.surveyCreator.text,
        locales: locales
      };
      this.post({
        url: route('questionnaire.translate'),
        data: data,
        urlRelative: false,
        handleError: false
      }).then((response) => {
        this.surveyCreator.changeText(response.data.translation);
        this.surveyCreator.showTranslationEditor();
        this.modalOpen = false;
        showToast('Translations generated!', '#28a745', 'bottom-right');
      }).catch(error => {
        console.error(error);
        this.modalOpen = false;
      });
    },
    saveQuestionnaire() {
      let locales = this.surveyCreator.translationValue.getSelectedLocales();
      if (locales[0] === "") {
        locales = [];
      }
      const data = {
        title: this.questionnaire.default_fields_translation.title,
        description: this.questionnaire.default_fields_translation.description,
        goal: this.questionnaire.goal,
        language: this.questionnaire.default_language_id,
        project_ids: [],
        statistics_page_visibility_lkp_id: this.questionnaire.statistics_page_visibility_lkp_id,
        content: this.surveyCreator.text,
        lang_codes: locales,
        extra_fields_translations: document.getElementById('extra_translations').value,
        max_votes_num: this.questionnaire.max_votes_num,
        show_general_statistics: this.questionnaire.show_general_statistics,
        type_id: this.questionnaire.type_id
      };
      $("#project-ids").val().map((x) => {
        data.project_ids.push(parseInt(x));
      });

      if (this.formInvalid(data))
        return swal({
          title: "Fields Missing!",
          text: "Please provide a title, description, goal, and at least one project.",
          type: "warning",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "OK",
        });

      this.post({
        url: this.questionnaire.id
            ? route('update-questionnaire', this.questionnaire.id)
            : route('store-questionnaire'),
        data: data,
        urlRelative: false,
        handleError: false
      }).then((response) => {
        swal({
          title: "Success!",
          text: "The questionnaire has been successfully stored.",
          type: "success",
          confirmButtonClass: "btn-success",
          confirmButtonText: "OK",
        }, function () {
          window.location = route('edit-questionnaire', response.data.id);
        });
      }).catch(error => {
        swal({
          title: "Oops!",
          text: "An error occurred, please try again later." + error.toString(),
          type: "error",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "OK",
        });
      });

    },
    formInvalid(data) {
      return !data.title || !data.description || !data.goal || !data.project_ids.length;
    },
    shuffle(array) {
      for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        const temp = array[i];
        array[i] = array[j];
        array[j] = temp;
      }
      return array;
    },
    assignRandomColorsToChoices(jsonStr) {
      const colors = this.shuffle(this.colors);
      let json = JSON.parse(jsonStr);
      let colorIndex = 0;
      for (let i = 0; i < json.pages.length; i++) {
        for (let j = 0; j < json.pages[i].elements.length; j++) {
          if (json.pages[i].elements[j].choices) {
            for (let choiceIndex = 0; choiceIndex < json.pages[i].elements[j].choices.length; choiceIndex++) {
              if (!json.pages[i].elements[j].choices[choiceIndex].statsColor) {
                json.pages[i].elements[j].choices[choiceIndex].statsColor = colors[colorIndex];
                colorIndex++;
                if (colorIndex === colors.length)
                  colorIndex = 0;
              }
            }
          }
          if (json.pages[i].elements[j].columns) {
            for (let colIndex = 0; colIndex < json.pages[i].elements[j].columns.length; colIndex++) {
              if (!json.pages[i].elements[j].columns[colIndex].statsColor) {
                json.pages[i].elements[j].columns[colIndex].statsColor = colors[colorIndex];
                colorIndex++;
                if (colorIndex === colors.length)
                  colorIndex = 0;
              }
            }
          }
          if (json.pages[i].elements[j].rows) {
            for (let rowIndex = 0; rowIndex < json.pages[i].elements[j].rows.length; rowIndex++) {
              if (!json.pages[i].elements[j].rows[rowIndex].statsColor) {
                json.pages[i].elements[j].rows[rowIndex].statsColor = colors[colorIndex];
                colorIndex++;
                if (colorIndex === colors.length)
                  colorIndex = 0;
              }
            }
          }
        }
      }
      return JSON.stringify(json);
    }

  }
}
</script>

<style scoped lang="scss">


</style>
