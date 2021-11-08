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
    <modal
        :hide-header="false"
        :open="signInModalOpen"
        :allow-close="true"
        @canceled="signInModalOpen = false">
      <template v-slot:body>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-10 text-center mx-auto py-5">
              <h4 class="mt-0 p-0 mb-5 text-center message">Please sign in to vote</h4>
              <a class="btn btn-primary btn-lg w-100" :href="getSignInUrl()">Sign in</a>
            </div>
          </div>
        </div>
      </template>
    </modal>
  </div>
</template>

<script>
import * as Survey from "survey-knockout";
import * as SurveyAnalytics from "survey-analytics";
import {mapActions} from "vuex";
import FreeTextQuestionStatisticsCustomVisualizer, {AnswersData} from "./FreeTextQuestionStatisticsCustomVisualizer";

export default {
  props: {
    questionnaire: {
      type: Object,
      default: function () {
        return {}
      }
    },
    userId: Number
  },
  data: function () {
    return {
      survey: null,
      questions: [],
      statsPanelIndexToColors: new Map(),
      loading: false,
      questionTypesToApplyCustomTextsTableVisualizer: ["text", "comment"],
      signInModalOpen: false
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
        .locales["en"]["visualizer_freeTextVisualizer"] = "Responses Table";

    this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
    this.questions = this.survey.getAllQuestions();
    this.getColorsForCrowdSourcingProject();
  },
  mounted() {
    this.listenForVoteClickEvent();
  },
  methods: {
    ...mapActions([
      'get',
      'post',
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
        const answers = _.map(response.data, function (response) {
          return {
            answerObj: JSON.parse(response.response_json_translated ?? response.response_json),
            respondent_user_id: response.user_id
          }
        });
        if (this.userId) {
          this.get({
            url: route('questionnaire.answer-votes', this.questionnaire.id),
            data: {},
            urlRelative: false
          }).then(response => {
            this.initStatistics(answers, response.data);
            this.loading = false;
          });
        } else {
          this.initStatistics(answers, []);
          this.loading = false;
        }
      });
    },
    initStatistics(answers, answerVotes) {
      AnswersData.answerVotes = answerVotes;
      AnswersData.userId = this.userId;
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
    },
    listenForVoteClickEvent() {
      const instance = this;
      $(document).on('click', 'body .vote-btn', function () {
        if (instance.userId)
          instance.handleVote(
              $(this),
              $(this).data('question-name'),
              parseInt($(this).data('respondent-user-id')),
              $(this).hasClass('upvote')
          );
        else
          instance.displayLoginPrompt();
      });
    },
    handleVote(element, questionName, respondentUserId, upvote) {
      this.post({
        url: route('questionnaire.answer-votes.vote'),
        data: {
          questionnaire_id: this.questionnaire.id,
          question_name: questionName,
          respondent_user_id: respondentUserId,
          voter_user_id: this.userId,
          upvote: upvote
        },
        urlRelative: false
      }).then(response => {
        if (upvote) {
          // if the user has already upvoted, subtract one
          // if the user has downvoted the same question, subtract one from downvotes and cancel the downvote class
          this.updateCountElement(element, 'user-upvoted', 'user-downvoted', 'downvote');
          element.toggleClass('user-upvoted');
        } else {
          // if the user has already downvoted, subtract one
          // if the user has upvoted the same question, subtract one from downvotes and cancel the downvote class
          this.updateCountElement(element, 'user-downvoted', 'user-upvoted', 'upvote');
          element.toggleClass('user-downvoted');
        }
      });
    },
    displayLoginPrompt() {
      this.signInModalOpen = true;
    },
    updateCountElement(element, className, oppositeClassName, oppositeButtonClassName) {
      let countEl = element.find(".count:first");
      let count = parseInt(countEl.html());
      if (element.hasClass(className)) {
        count -= 1;
      } else {
        count += 1;
      }
      countEl.html(count);

      const parent = element.closest(".reaction-buttons");
      let oppositeButtonEl = parent.find("." + oppositeButtonClassName + ":first");
      if (oppositeButtonEl && oppositeButtonEl.hasClass(oppositeClassName)) {
        oppositeButtonEl.removeClass(oppositeClassName);
        let countEl = oppositeButtonEl.find(".count:first");
        let count = parseInt(countEl.html()) - 1;
        countEl.html(count);
      }
    },
    getSignInUrl() {
      return route('login') + '?redirectTo=' + window.location.href;
    }
  }
}
</script>

<style lang="scss">
@import "~survey-jquery/modern.min.css";
@import "~survey-analytics/survey.analytics.min.css";
@import "resources/assets/sass/questionnaire/statistics";
</style>
