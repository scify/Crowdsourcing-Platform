<template>
  <div class="container-fluid">
    <div v-if="loading" class="row loader-container">
      <div class="col">
        <div class="d-flex justify-content-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-for="index in questions.length">
      <div class="col-lg-11 col-md-12 col-sm-12 mx-auto">
        <div class="survey-statistics-container" :id="'survey-statistics-container_' + (index - 1)"></div>
      </div>
    </div>
    <store-modal
        :show-ok-button="true"
        @okClicked="closeModal"></store-modal>
  </div>
</template>

<script>
import * as Survey from "survey-knockout";
import * as SurveyAnalytics from "survey-analytics";
import {mapActions} from "vuex";
import FreeTextQuestionStatisticsCustomVisualizer from "./FreeTextQuestionStatisticsCustomVisualizer";

export default {
  props: {
    questionnaire: {
      type: Object,
      default: function () {
        return {}
      }
    }
  },
  data: function () {
    return {
      survey: null,
      questions: [],
      statsPanelIndexToColors: new Map(),
      loading: false,
      questionTypesToApplyCustomTextsTableVisualizer: ["text", "comment"]
    }
  },
  created() {
    this.loading = true;
    Survey
        .JsonObject
        .metaData
        .addProperty("itemvalue", {
          name: "statsColor"
        });
    Survey.StylesManager.applyTheme("bootstrap");
    SurveyAnalytics.VisualizationPanel.haveCommercialLicense = true;
    for (let i = 0; i < this.questionTypesToApplyCustomTextsTableVisualizer.length; i++) {
      const type = this.questionTypesToApplyCustomTextsTableVisualizer[i];
      // Register custom visualizer for the free text question type
      let visualizers = SurveyAnalytics.VisualizationManager.getVisualizersByType(type);
      // arrange visualizers
      const wordCloud = visualizers[0];
      const simpleTable = visualizers[1];

      SurveyAnalytics
          .VisualizationManager
          .unregisterVisualizer(type, wordCloud);
      SurveyAnalytics
          .VisualizationManager
          .unregisterVisualizer(type, simpleTable);
      SurveyAnalytics
          .VisualizationManager
          .registerVisualizer(type, FreeTextQuestionStatisticsCustomVisualizer);
      SurveyAnalytics
          .VisualizationManager
          .registerVisualizer(type, wordCloud);
    }
    // Set localized title of this visualizer
    SurveyAnalytics
        .localization
        .locales["en"]["visualizer_freeTextVisualizer"] = "Translated Responses";

    this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
    this.questions = this.survey.getAllQuestions();
    this.getColorsForCrowdSourcingProject();
  },
  mounted() {
  },
  methods: {
    ...mapActions([
      'get',
      'handleError',
      'closeModal'
    ]),
    getColorsForCrowdSourcingProject() {
      this.get({
        url: route('crowd-sourcing-project.get-colors', this.questionnaire.project_id),
        data: {},
        urlRelative: false
      }).then(response => {
        this.colors = response.data;
        this.getQuestionnaireResponses();
      });
    },
    getQuestionnaireResponses() {
      this.get({
        url: route('questionnaire.responses', this.questionnaire.id),
        data: {},
        urlRelative: false
      }).then(response => {
        const answers = _.map(_.map(response.data, 'response_json'), JSON.parse);
        this.initStatistics(answers);
        this.loading = false;
      });
    },
    initStatistics(answers) {
      for (let i = 0; i < this.questions.length; i++) {

        if (!this.shouldDrawStatistics(this.questions[i]))
          continue;

        const colors = this.convertColorNamesToColorCodes(this.getColorsForQuestion(this.questions[i]));

        if (colors.length) {
          if (this.questions[i].otherItem) {
            colors.unshift("blue");
          }
          this.statsPanelIndexToColors.set(i, colors);
        }

        let visPanel = new SurveyAnalytics.VisualizationPanel(
            [this.questions[i]],
            answers,
            {
              labelTruncateLength: -1,
              allowDynamicLayout: false,
              index: i
            }
        );
        visPanel.showHeader = false;

        let instance = this;
        visPanel.visualizers.forEach((visualizer) => {
          if (!visualizer.onAnswersDataReady) return;
          visualizer.onAnswersDataReady.add((sender, options) => {
            if (instance.statsPanelIndexToColors.has(sender.options.index))
              options.colors = instance.statsPanelIndexToColors.get(sender.options.index);
          });
        });
        visPanel.render(document.getElementById('survey-statistics-container_' + i));
      }
    },
    shouldDrawStatistics(question) {
      return question.getType().toLowerCase() !== 'html'
    },
    getColorsForQuestion(question) {
      let choices = [];
      if (question.choices)
        choices = question.choices;
      else if (question.columns)
        choices = question.columns;
      else
        return [];

      return _.map(choices, 'statsColor');
    },
    convertColorNamesToColorCodes(colorNames) {
      let colorCodes = [];
      for (let i = 0; i < colorNames.length; i++) {
        const color = _.find(this.colors, ['color_name', colorNames[i]]);
        if (color)
          colorCodes.push(color.color_code);
      }
      return colorCodes;
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "~survey-jquery/modern.min.css";
@import "~survey-analytics/survey.analytics.min.css";
</style>
