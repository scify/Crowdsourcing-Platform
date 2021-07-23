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
              <label for="language">Project the Questionnaire belongs to</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <select name="project_id" id="project" class="select2">

                <option v-for="project in projects" :value="project.id"
                        v-model="questionnaire.project_id">
                  {{ project.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="language">Statistics page visibility</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <select name="statistics_page_visibility_lkp_id" id="statistics_page_visibility_lkp_id"
                      class="select2">
                <option v-for="visibilityLkp in questionnaireStatisticsPageVisibilityLkp"
                        v-model="questionnaire.statistics_page_visibility_lkp_id">
                  {{visibilityLkp.title}}
                </option>
              </select>
            </div>
          </div>
          <div v-if="maximumPrerequisiteOrder" class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="prerequisite_order">Prerequisite Order</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <select name="prerequisite_order" id="prerequisite_order" class="select2">
                <option v-for="index in maximumPrerequisiteOrder"
                        v-model="questionnaire.prerequisite_order">
                  {{index}}
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
                     v-model="questionnaire.title">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label for="description">Description - Motto</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="description" id="description"
                                      required
                                      v-model="questionnaire.description"
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
              <label for="language">Default Language</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">

              <select name="language_id" id="language" class="select2">
                <option v-for="language in languages"
                        v-model="questionnaire.default_language_id"
                        :selected="questionnaire.default_language_id === language.id">
                  {{language.language_name}}
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
  </div>
</template>

<script>
import {mapActions} from "vuex";
import * as Survey from "survey-knockout";
import * as SurveyCreator from "survey-creator";

export default {
  created() {
    this.questionnaire = this.questionnaireData;
    if (!this.questionnaire.project_id)
      this.questionnaire.project_id = this.projects[0].id;
    if (!this.questionnaire.statistics_page_visibility_lkp_id)
      this.questionnaire.statistics_page_visibility_lkp_id = this.questionnaireStatisticsPageVisibilityLkp[0].id
  },
  mounted() {
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
    maximumPrerequisiteOrder: false
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
        project_id: null
      },
      surveyCreator: null,
      questionTypes: ["boolean", "checkbox", "comment", "dropdown",
        "html", "matrix", "matrixdropdown", "matrixdynamic", "radiogroup", "rating", "text"],
      colors: [],
      isTranTabInitialised: false
    }
  },
  methods: {
    ...mapActions([
      'get',
      'handleError',
      'post'
    ]),
    getColorsForCrowdSourcingProject() {
      this.get({
        url: route('crowd-sourcing-project.get-colors', this.questionnaire.project_id),
        data: {},
        urlRelative: false
      }).then(response => {
        this.colors = _.map(response.data, 'color_name').sort();
        this.initQuestionnaireEditor();
      });
    },
    initQuestionnaireEditor() {

      Survey.surveyLocalization.supportedLocales = _.map(this.languages, 'language_code');
      for (let i = 0; i < this.languages.length; i++) {
        Survey.surveyLocalization.localeNames[this.languages[i].language_code] = this.languages[i].language_name;
      }
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
      this.surveyCreator.onActiveTabChanged.add((sender, options) => {
        if (options.tabName == "translation") {
          if (!instance.isTranTabInitialised) {
            sender.translation.setSelectedLocales(usedLocales);
            instance.isTranTabInitialised = true;
          }
        }
      });
    },
    saveQuestionnaire() {
      if (this.formInvalid())
        return swal({
          title: "Fields Missing!",
          text: "Please provide a title, description and goal.",
          type: "warning",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "OK",
        });
      let locales = this.surveyCreator.translationValue.getSelectedLocales();
      if (locales[0] === "") {
        locales = [];
      }
      const data = {
        title: this.questionnaire.title,
        description: this.questionnaire.description,
        goal: this.questionnaire.goal,
        language: this.questionnaire.default_language_id,
        project: this.questionnaire.project_id,
        prerequisite_order: this.questionnaire.prerequisite_order,
        statistics_page_visibility_lkp_id: this.questionnaire.statistics_page_visibility_lkp_id,
        content: this.surveyCreator.text,
        lang_codes: locales
      };
      const instance = this;

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
          window.location = route('edit-questionnaire', instance.questionnaire.id);
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
    formInvalid() {
      return !this.questionnaire.title || !this.questionnaire.description || !this.questionnaire.goal;
    },
    getRandomColor() {
      return this.colors[Math.floor(Math.random() * this.colors.length)];
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
