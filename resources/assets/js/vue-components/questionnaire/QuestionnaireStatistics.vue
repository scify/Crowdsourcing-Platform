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
    <modal
        :hide-header="false"
        :open="maxVotesModalOpen"
        :allow-close="true"
        @canceled="maxVotesModalOpen = false">
      <template v-slot:body>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-10 text-center mx-auto py-5">
              <h4 class="mt-0 p-0 mb-5 text-center message">This questionnaire allows up to
                {{ questionnaire.max_votes_num }} votes.</h4>
            </div>
          </div>
        </div>
      </template>
    </modal>
    <modal
        :hide-header="false"
        :open="annotationModalOpen"
        :allow-close="true"
        @canceled="annotationModalOpen = false">
      <template v-slot:header>
        <h5 class="modal-title pl-2">Annotate answer</h5>
      </template>
      <template v-slot:body>
        <div class="container py-4">
          <div class="row justify-content-center">
            <div class="col-12 text-center mx-auto mb-4">
              <textarea class="form-control" rows="3" v-model="annotation.annotation_text"></textarea>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 text-center mx-auto mb-3">
              <button @click="saveAnnotation" :disabled="annotationLoading || annotation.annotation_text.length === 0"
                      class="btn btn-primary btn-lg w-100">
                <span class="mr-2">Save</span><span v-if="annotationLoading"
                                                    class="spinner-border spinner-border-sm"
                                                    role="status"
                                                    aria-hidden="true"></span></button>
            </div>
            <div class="col-12 text-center mx-auto">
              <button @click="deleteAnnotation" :disabled="annotationLoading"
                      class="btn btn-outline-danger btn-lg w-100">
                <span class="mr-2">Delete</span><span v-if="annotationLoading"
                                                      class="spinner-border spinner-border-sm"
                                                      role="status"
                                                      aria-hidden="true"></span></button>
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
import Promise from "lodash/_Promise";
import _ from "lodash";

export default {
  props: {
    questionnaire: {
      type: Object,
      default: function () {
        return {}
      }
    },
    userId: Number,
    userCanAnnotateAnswers: {
      type: Number,
      default: 0
    }
  },
  data: function () {
    return {
      survey: null,
      questions: [],
      statsPanelIndexToColors: new Map(),
      loading: false,
      questionTypesToApplyCustomTextsTableVisualizer: ["text", "comment"],
      signInModalOpen: false,
      maxVotesModalOpen: false,
      annotationModalOpen: false,
      annotationLoading: false,
      annotation: {
        annotation_text: ''
      },
      numOfVotesByCurrentUser: 0
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
    this.listenForAnnotateClickEvent();
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
        this.getQuestionnaireDataAndInitStatistics();
      });
    },
    getQuestionnaireDataAndInitStatistics() {
      Promise.all([
        this.getQuestionnaireResponses(),
        this.getQuestionnaireAnswerVotes(),
        this.getQuestionnaireAnswerAnnotations()]).then(results => {
        this.initStatistics(results[0], results[1], results[2])
      });
    },
    getQuestionnaireResponses() {
      const instance = this;
      return new Promise(function callback(resolve, reject) {
        instance.get({
          url: route('questionnaire.responses', instance.questionnaire.id),
          data: {},
          urlRelative: false
        }).then(response => {
          const answers = _.map(response.data, function (response) {
            return {
              answerObj: JSON.parse(response.response_json_translated ?? response.response_json),
              respondent_user_id: response.user_id
            }
          });
          resolve(answers);
        }).catch(e => reject(e));
      });
    },
    getQuestionnaireAnswerVotes() {
      return this.get({
        url: route('questionnaire.answer-votes', this.questionnaire.id),
        data: {},
        urlRelative: false
      }).then(res => res.data);
    },
    getQuestionnaireAnswerAnnotations() {
      return this.get({
        url: route('questionnaire.answer-annotations', this.questionnaire.id),
        data: {},
        urlRelative: false
      }).then(res => res.data);
    },
    initStatistics(answers, answerVotes, answerAnnotations) {
      this.numOfVotesByCurrentUser = _.filter(answerVotes, {voter_user_id: this.userId}).length;
      AnswersData.answerVotes = answerVotes;
      AnswersData.answerAnnotations = answerAnnotations;
      AnswersData.userId = this.userId;
      AnswersData.userCanAnnotateAnswers = this.userCanAnnotateAnswers;
      for (let i = 0; i < this.questions.length; i++) {
        let answersForPanel = answers;

        if (!this.questionTypesToApplyCustomTextsTableVisualizer.includes(this.questions[i].getType()))
          answersForPanel = _.map(answers, 'answerObj');

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
            answersForPanel,
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
      this.loading = false;
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
        const actionIsUpvote = $(this).hasClass('upvote');
        const userHasAlreadyUpVoted = $(this).hasClass('user-upvoted');
        const element = $(this);
        if (instance.userId) {
          if (!userHasAlreadyUpVoted && actionIsUpvote && instance.numOfVotesByCurrentUser >= instance.questionnaire.max_votes_num)
            return instance.displayMaxVotesMessage()
          instance.performVoteCall(
              element.data('question-name'),
              parseInt(element.data('respondent-user-id')),
              actionIsUpvote
          );
          if (actionIsUpvote) {
            if (userHasAlreadyUpVoted)
              instance.numOfVotesByCurrentUser -= 1;
            else
              instance.numOfVotesByCurrentUser += 1;
            // if the user has already upvoted, subtract one
            // if the user has downvoted the same question, subtract one from downvotes and cancel the downvote class
            instance.updateCountElement(element, 'user-upvoted', 'user-downvoted', 'downvote');
            element.toggleClass('user-upvoted');
          } else {
            // if the user has already downvoted, subtract one
            // if the user has upvoted the same question, subtract one from downvotes and cancel the downvote class
            instance.updateCountElement(element, 'user-downvoted', 'user-upvoted', 'upvote');
            element.toggleClass('user-downvoted');
          }
        } else
          instance.displayLoginPrompt();
      });
    },
    listenForAnnotateClickEvent() {
      const instance = this;
      $(document).on('click', 'body .annotate-btn', function () {
        instance.annotation = {
          annotation_text: $(this).attr('data-annotation'),
          question_name: $(this).data('question'),
          respondent_user_id: $(this).data('respondent')
        };
        instance.annotationModalOpen = true;
      });
    },
    performVoteCall(questionName, respondentUserId, upvote) {
      this.post({
        url: route('questionnaire.answer-votes.create'),
        data: {
          questionnaire_id: this.questionnaire.id,
          question_name: questionName,
          respondent_user_id: respondentUserId,
          voter_user_id: this.userId,
          upvote: upvote
        },
        urlRelative: false
      }).then(response => {

      });
    },
    displayLoginPrompt() {
      this.signInModalOpen = true;
    },
    displayMaxVotesMessage() {
      this.maxVotesModalOpen = true;
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
    },
    saveAnnotation() {
      this.annotationLoading = true;
      this.post({
        url: route('questionnaire.answer-annotations.create'),
        data: {
          questionnaire_id: this.questionnaire.id,
          question_name: this.annotation.question_name,
          respondent_user_id: this.annotation.respondent_user_id,
          annotator_user_id: this.userId,
          annotation_text: this.annotation.annotation_text
        },
        urlRelative: false
      }).then(response => {
        this.annotationLoading = false;
        this.annotationModalOpen = false;
        const cellElement = $("#" + "answer_" + this.annotation.question_name + "_" + this.annotation.respondent_user_id);
        const annotationElement = cellElement.find('.annotation-wrapper');
        if (annotationElement.length !== 0)
          annotationElement.find(".annotation-text").html(this.annotation.annotation_text);
        else {
          cellElement.find(".annotation-button").after('<div class="annotation-wrapper"><b>Comment by the admin:</b><p class="annotation-text">'
              + this.annotation.annotation_text
              + '</p></div><b>Original answer:</b>');
        }
        cellElement.find(".annotate-btn").attr('data-annotation', this.annotation.annotation_text);
        this.annotation = {
          annotation_text: ''
        };
      });
    },
    deleteAnnotation() {
      this.annotationLoading = true;
      this.post({
        url: route('questionnaire.answer-annotations.delete'),
        data: {
          questionnaire_id: this.questionnaire.id,
          question_name: this.annotation.question_name,
          respondent_user_id: this.annotation.respondent_user_id
        },
        urlRelative: false
      }).then(response => {
        this.annotationLoading = false;
        this.annotationModalOpen = false;
        const cellElement = $("#" + "answer_" + this.annotation.question_name + "_" + this.annotation.respondent_user_id);
        const annotationElement = cellElement.find('.annotation-wrapper');
        if (annotationElement.length)
          annotationElement.remove();
        this.annotation = {
          annotation_text: ''
        };
      });
    }
  }
}
</script>

<style lang="scss">
@import "~survey-jquery/modern.min.css";
@import "~survey-analytics/survey.analytics.min.css";
@import "resources/assets/sass/questionnaire/statistics";
</style>
