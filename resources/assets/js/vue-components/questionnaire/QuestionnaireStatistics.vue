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
              <h4 class="mt-0 p-0 mb-5 text-center message">You can vote up to
                <b>{{ questionnaire.max_votes_num }}</b> times.</h4>
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
        <h5 class="modal-title pl-2">Moderate Answer</h5>
      </template>
      <template v-slot:body>
        <div class="container py-4">
          <div class="row justify-content-center">
            <div class="col-12 text-center mx-auto mb-3">
              <select
                  v-model="annotation.admin_review_status_id"
                  id="annotation-admin-review-status-id" class="form-control">
                <option v-for="status in answerAnnotationAdminReviewStatuses"
                        :value="status.id">
                  {{ status.name }}
                </option>
              </select>
            </div>
          </div>
          <div v-if="displayAnnotatorPublicComment" class="row justify-content-center">
            <div class="col-12 text-center mx-auto mb-4">
              <textarea class="form-control" rows="3" v-model="annotation.annotation_text"
                        placeholder="A comment provided by the annotator (this is optional, but if you enter it will be publicly displayed)"></textarea>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 text-center mx-auto mb-4">
              <textarea class="form-control" rows="2" v-model="annotation.admin_review_comment"
                        placeholder="A private note for the moderator. This is not visible to users. It is useful for you in case you want to write down to remember for later"></textarea>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 text-center mx-auto mb-3">
              <button @click="saveAnnotation" :disabled="annotationSaveLoading"
                      class="btn btn-primary btn-lg w-100">
                <span class="mr-2">Save</span><span v-if="annotationSaveLoading"
                                                    class="spinner-border spinner-border-sm"
                                                    role="status"
                                                    aria-hidden="true"></span></button>
            </div>
            <div class="col-12 text-center mx-auto">
              <button @click="deleteAnnotation" :disabled="annotationDeleteLoading"
                      class="btn btn-outline-danger btn-lg w-100">
                <span class="mr-2">Undo/Remove your action</span><span v-if="annotationDeleteLoading"
                                                                       class="spinner-border spinner-border-sm"
                                                                       role="status"
                                                                       aria-hidden="true"></span></button>
            </div>
          </div>
        </div>
      </template>
    </modal>
    <div v-if="userCanAnnotateAnswers && questionnaireHasManyProjects" id="moderator-toolbar">
      <div class="container">
        <div class="row">
          <div class="col-12">
            You are logged in as moderator.
            <span v-if="projectFilterSelectedOption==-1">Select a project to filter the responses:</span>
            <span v-else>You have filtered the responses, <strong> currently viewing:</strong></span>
            <select v-model="projectFilterSelectedOption" @change="onFilterProject($event)">
              <option value="-1">View all</option>
              <option v-for="p in projects"
                      :value="p.id">
                {{ p.slug }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as Survey from "survey-knockout";
import * as SurveyAnalytics from "survey-analytics";
import {mapActions} from "vuex";
import FreeTextQuestionStatisticsCustomVisualizer, {AnswersData} from "./FreeTextQuestionStatisticsCustomVisualizer";
import Promise from "lodash/_Promise";
import _ from "lodash";
import {showToast} from "../../common-utils";

export default {
  props: {
    questionnaire: {
      type: Object,
      default: function () {
        return {}
      }
    },
    projects: {
      type: Array,
      default: function () {
        return []
      }
    },
    userId: Number,
    userCanAnnotateAnswers: {
      type: Number,
      default: 0
    },
    projectFilter: {
      type: Number,
      default: -1
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
      annotationSaveLoading: false,
      annotationDeleteLoading: false,
      annotation: {
        annotation_text: null,
        admin_review_status_id: null,
        admin_review_comment: null
      },
      numOfVotesByCurrentUser: 0,
      answerAnnotationAdminReviewStatuses: [],
      projectFilterSelectedOption: this.$props.projectFilter
    }
  },
  computed: {
    "displayAnnotatorPublicComment": function () {
      //if id '1', 'Reviewed by moderator - no further action',
      // or id '4', 'Toxic - always hide answer', 'The answer was reviewed by a moderator and it was marked as toxic. It will never be shown in the statistics.'
      // dont display
      return (this.annotation.admin_review_status_id != 1
          && this.annotation.admin_review_status_id != 4)
    },
    "questionnaireHasManyProjects":function(){
      return this.$props.projects.length>1;
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
        this.getQuestionnaireAnswerAnnotations(),
        this.getQuestionnaireAnswerAdminAnalysisStatuses()
      ]).then(results => {
        this.initStatistics(results[0], results[1], results[2], results[3])
      });
    },
    getQuestionnaireResponses() {
      const instance = this;
      return new Promise(function callback(resolve, reject) {
        instance.get({
          url: route('questionnaire.responses', instance.questionnaire.id, instance.projectFilter),
          data: {},
          urlRelative: false
        }).then(response => {
          console.log(response.data);
          const answers = _.map(response.data, function (response) {
            return {
              answer_id: response.id,
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
    getQuestionnaireAnswerAdminAnalysisStatuses() {
      return this.get({
        url: route('questionnaire.answers-admin-analysis-statuses.get'),
        data: {},
        urlRelative: false
      }).then(res => res.data);
    },
    initStatistics(answers, answerVotes, answerAnnotations, adminAnalysisStatuses) {
      this.answerAnnotationAdminReviewStatuses = adminAnalysisStatuses;
      this.numOfVotesByCurrentUser = _.filter(answerVotes, {voter_user_id: this.userId}).length;
      AnswersData.answerVotes = answerVotes;
      AnswersData.answerAnnotations = answerAnnotations;
      AnswersData.userId = this.userId;
      AnswersData.userCanAnnotateAnswers = this.userCanAnnotateAnswers;
      AnswersData.numberOfVotesForQuestionnaire = this.questionnaire.max_votes_num;
      AnswersData.languageResources = window.language[window.Laravel.locale].statistics;

      for (let i = 0; i < this.questions.length; i++) {
        let answersForPanel = answers;
        const currentQuestionName = this.questions[i].name;
        if (!this.questionHasCustomVisualizer(this.questions[i])) {
          answersForPanel = _.map(answers, 'answerObj');
          answersForPanel = Object.values(_.pickBy(answersForPanel, function (value, key) {
            return currentQuestionName in value && value[currentQuestionName] !== undefined;
          }));
        }

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
              allowSelection: false,
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
    questionHasCustomVisualizer(question) {
      return this.questionTypesToApplyCustomTextsTableVisualizer.includes(question.getType());
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
            return instance.displayMaxVotesMessage();
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
          const remainingVotes = (instance.questionnaire.max_votes_num - instance.numOfVotesByCurrentUser);
          let votesWord = 'vote';
          if (remainingVotes > 1)
            votesWord += 's';
          showToast('You have ' + remainingVotes
              + ' ' + votesWord + ' left!', '#28a745', 'bottom-right');
        } else
          instance.displayLoginPrompt();
      });
    },
    listenForAnnotateClickEvent() {
      const instance = this;
      $(document).on('click', 'body .annotate-btn', function () {
        let adminReviewStatusId = parseInt($(this).attr('data-annotation-admin-review-status-id'));
        let annotationText = $(this).attr('data-annotation');
        let adminReviewComment = $(this).attr('data-annotation-admin-review-comment');
        if (!adminReviewStatusId)
          adminReviewStatusId = instance.answerAnnotationAdminReviewStatuses[0].id;
        if (annotationText === "null")
          annotationText = null;
        if (adminReviewComment === "null")
          adminReviewComment = null;

        instance.annotation = {
          annotation_text: annotationText,
          admin_review_status_id: adminReviewStatusId,
          admin_review_comment: adminReviewComment,
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
      return route('login', window.Laravel.locale) + '?redirectTo=' + window.location.href;
    },
    saveAnnotation() {
      this.annotationSaveLoading = true;
      this.post({
        url: route('questionnaire.answer-annotations.create'),
        data: {
          questionnaire_id: this.questionnaire.id,
          question_name: this.annotation.question_name,
          respondent_user_id: this.annotation.respondent_user_id,
          annotator_user_id: this.userId,
          annotation_text: this.annotation.annotation_text,
          admin_review_status_id: this.annotation.admin_review_status_id,
          admin_review_comment: this.annotation.admin_review_comment
        },
        urlRelative: false
      }).then(response => {
        this.annotationSaveLoading = false;
        this.annotationModalOpen = false;
        const cellElement = $("#" + "answer_" + this.annotation.question_name + "_" + this.annotation.respondent_user_id);
        const annotationElement = cellElement.find('.annotation-wrapper');
        if (this.annotation.annotation_text) {
          if (annotationElement.length !== 0)
            annotationElement.find(".annotation-text").html(this.annotation.annotation_text);
          else {
            cellElement.find(".annotation-button").after('<div class="annotation-wrapper"><b>Comment by the admin:</b><p class="annotation-text">'
                + this.annotation.annotation_text
                + '</p></div><b>Original answer:</b>');
          }
        }
        cellElement.find(".annotate-btn").attr('data-annotation', this.annotation.annotation_text);
        cellElement.find(".annotate-btn").attr('data-annotation-admin-review-status-id', this.annotation.admin_review_status_id);
        cellElement.find(".annotate-btn").attr('data-annotation-admin-review-comment', this.annotation.admin_review_comment);
        cellElement.find(".annotate-btn").append('<i class="fa fa-check" title="This answer has been reviewed by a moderator"></i>')
      });
    },
    deleteAnnotation() {
      this.annotationDeleteLoading = true;
      this.post({
        url: route('questionnaire.answer-annotations.delete'),
        data: {
          questionnaire_id: this.questionnaire.id,
          question_name: this.annotation.question_name,
          respondent_user_id: this.annotation.respondent_user_id
        },
        urlRelative: false
      }).then(response => {
        this.annotationDeleteLoading = false;
        this.annotationModalOpen = false;
        const cellElement = $("#" + "answer_" + this.annotation.question_name + "_" + this.annotation.respondent_user_id);
        const annotationElement = cellElement.find('.annotation-wrapper');
        cellElement.find(".fa-check").remove();
        if (annotationElement.length)
          annotationElement.remove();
        this.annotation = {
          annotation_text: ''
        };
      });
    },
    onFilterProject(event) {
      window.location.href = route('questionnaire.statistics', window.Laravel.locale, this.questionnaire.id, event.target.value);
    }
  }
}
</script>

<style lang="scss">
@import "~survey-jquery/modern.min.css";
@import "~survey-analytics/survey.analytics.min.css";
@import "resources/assets/sass/questionnaire/statistics";

.fa-check {
  color: green;
  display: inline-block;
  margin-left: 5px;
}

#moderator-toolbar {
  text-align: center;
  font-size: 1.2rem;
  position: fixed;
  padding: 10px;
  bottom: 0;
  left: 0;
  right: 0;
  min-height: 35px;
  background-color: rgba(230, 230, 230, 1);
  box-shadow: 0px 0 10px rgba(0, 0, 0, 0.8);

  select {
    background-color: white;
    border: none;
    margin-left: 5px;
  }
}
</style>
