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
      <div class="col-lg-8 col-md-10 col-sm-11 mx-auto">
        <div :id="'survey-statistics-container_' + (index - 1)"></div>
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
      loading: false
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

    this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
    this.questions = this.survey.getAllQuestions();
    this.getQuestionnaireResponses();
  },
  mounted() {
  },
  methods: {
    ...mapActions([
      'get',
      'handleError',
      'closeModal'
    ]),
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

        const colors = this.getColorsForQuestion(this.questions[i]);
        if (colors.length) {
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

      let colors = _.map(choices, 'statsColor');
      if (question.otherItem) {
        colors.unshift("blue");
      }
      return colors;
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "~survey-jquery/modern.min.css";
@import "~survey-analytics/survey.analytics.min.css";
</style>
