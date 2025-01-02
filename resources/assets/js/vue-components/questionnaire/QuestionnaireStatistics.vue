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
		<div class="row">
			<div class="col-lg-11 col-md-12 col-sm-12 mx-auto">
				<div id="survey-statistics-container_default_visualizer" class="survey-statistics-container"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-11 col-md-12 col-sm-12 mx-auto">
				<div id="survey-statistics-container_custom_visualizer" class="survey-statistics-container"></div>
			</div>
		</div>
		<div v-if="userCanAnnotateAnswers" class="row mt-5 mb-1">
			<div class="col-lg-11 col-md-12 col-sm-12 mx-auto text-left">
				<h4>Download all responses</h4>
			</div>
		</div>
		<div v-if="userCanAnnotateAnswers && !responsesTableShown" class="row mt-2 mb-5">
			<div class="col-lg-11 col-md-12 col-sm-12 mx-auto">
				<button class="btn btn-primary" @click="showResponsesTable">Show Responses Table</button>
			</div>
		</div>
		<div v-if="userCanAnnotateAnswers" class="row mt-2 mb-5">
			<div class="col-lg-11 col-md-12 col-sm-12 mx-auto">
				<div id="questionnaire-responses-report" class="responses-report"></div>
			</div>
		</div>
		<store-modal :show-ok-button="true" @okClicked="closeModal"></store-modal>
		<common-modal
			:hide-header="false"
			:open="signInModalOpen"
			:allow-close="true"
			@canceled="signInModalOpen = false"
		>
			<template #body>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-10 text-center mx-auto py-5">
							<h4 class="mt-0 p-0 mb-5 text-center message">
								{{ trans("voting.sign_in_to_vote") }}
							</h4>
							<a class="btn btn-primary btn-lg w-50" :href="getSignInUrl()">
								{{ trans("questionnaire.sign_in") }}
							</a>
						</div>
					</div>
				</div>
			</template>
		</common-modal>
		<common-modal
			:hide-header="false"
			:open="maxVotesModalOpen"
			:allow-close="true"
			@canceled="maxVotesModalOpen = false"
		>
			<template #body>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-10 text-center mx-auto py-5">
							<h4
								class="mt-0 p-0 mb-5 text-center message"
								v-sane-html="
									trans('voting.you_can_vote_up_to', {
										votes: questionnaire.max_votes_num,
										entityName: trans('voting.entity_questionnaires'),
									})
								"
							></h4>
						</div>
					</div>
				</div>
			</template>
		</common-modal>
		<common-modal
			:hide-header="false"
			:open="annotationModalOpen"
			:allow-close="true"
			@canceled="annotationModalOpen = false"
		>
			<template #header>
				<h5 class="modal-title pl-2">Moderate Answer</h5>
			</template>
			<template #body>
				<div class="container py-4">
					<div class="row justify-content-center">
						<div class="col-12 text-center mx-auto mb-3">
							<select
								id="annotation-admin-review-status-id"
								v-model="annotation.admin_review_status_id"
								class="form-control"
							>
								<option
									v-for="status in answerAnnotationAdminReviewStatuses"
									:key="'status_' + status.id"
									:value="status.id"
								>
									{{ status.name }}
								</option>
							</select>
						</div>
					</div>
					<div v-if="displayAnnotatorPublicComment" class="row justify-content-center">
						<div class="col-12 text-center mx-auto mb-4">
							<textarea
								v-model="annotation.annotation_text"
								class="form-control"
								rows="3"
								placeholder="A comment provided by the annotator (this is optional, but if you enter it will be publicly displayed)"
							></textarea>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-12 text-center mx-auto mb-4">
							<textarea
								v-model="annotation.admin_review_comment"
								class="form-control"
								rows="2"
								placeholder="A private note for the moderator. This is not visible to users. It is useful for you in case you want to write down to remember for later"
							></textarea>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-12 text-center mx-auto mb-3">
							<button
								:disabled="annotationSaveLoading"
								class="btn btn-primary btn-lg w-100"
								@click="saveAnnotation"
							>
								<span class="mr-2">Save</span
								><span
									v-if="annotationSaveLoading"
									class="spinner-border spinner-border-sm"
									role="status"
									aria-hidden="true"
								></span>
							</button>
						</div>
						<div class="col-12 text-center mx-auto">
							<button
								:disabled="annotationDeleteLoading"
								class="btn btn-outline-danger btn-lg w-100"
								@click="deleteAnnotation"
							>
								<span class="mr-2">Undo/Remove your action</span
								><span
									v-if="annotationDeleteLoading"
									class="spinner-border spinner-border-sm"
									role="status"
									aria-hidden="true"
								></span>
							</button>
						</div>
					</div>
				</div>
			</template>
		</common-modal>
		<div v-if="userCanAnnotateAnswers && questionnaireHasManyProjects" id="moderator-toolbar">
			<div class="container">
				<div class="row">
					<div class="col-12">
						You are logged in as moderator.
						<span v-if="projectFilterSelectedOption === -1">Select a project to filter the responses:</span>
						<span v-else>You have filtered the responses, <strong> currently viewing:</strong></span>
						<select v-model="projectFilterSelectedOption" @change="onFilterProject($event)">
							<option value="-1">View all</option>
							<option v-for="p in projects" :key="'project_' + p.id" :value="p.id">
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
import * as Survey from "survey-jquery";
import * as SurveyAnalytics from "survey-analytics";
import { mapActions } from "vuex";
import FreeTextQuestionStatisticsCustomVisualizer, { AnswersData } from "./FreeTextQuestionStatisticsCustomVisualizer";
import FileQuestionStatisticsCustomVisualizer from "./FileQuestionStatisticsCustomVisualizer";
import { showToast } from "../../common-utils";
import { Tabulator } from "survey-analytics/survey.analytics.tabulator";
import CommonModal from "../common/ModalComponent.vue";
import StoreModal from "../common/StoreModalComponent.vue";
import { defineComponent } from "vue";
import transMixin from "../../vue-mixins/trans-mixin";

export default defineComponent({
	name: "QuestionnaireStatistics",
	mixins: [transMixin],
	components: {
		CommonModal,
		StoreModal,
	},
	props: {
		questionnaire: {
			type: Object,
			default: function () {
				return {};
			},
		},
		projects: {
			type: Array,
			default: function () {
				return [];
			},
		},
		userId: {
			type: Number,
			default: null,
		},
		userCanAnnotateAnswers: {
			type: Number,
			default: 0,
		},
		projectFilter: {
			type: Number,
			default: -1,
		},
		showFileTypeQuestionsStatistics: {
			type: Number,
			default: -1,
		},
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
				admin_review_comment: null,
			},
			numOfVotesByCurrentUser: 0,
			answerAnnotationAdminReviewStatuses: [],
			projectFilterSelectedOption: this.$props.projectFilter,
			answersData: {},
			responsesTableShown: false,
			responses: [],
		};
	},
	computed: {
		displayAnnotatorPublicComment: function () {
			// if id '1', 'Reviewed by moderator - no further action',
			// or id '4', 'Toxic - always hide answer', 'The answer was reviewed by a moderator, and it was marked as toxic.
			// It will never be shown in the statistics.'
			// don't display
			return this.annotation.admin_review_status_id !== 1 && this.annotation.admin_review_status_id !== 4;
		},
		questionnaireHasManyProjects: function () {
			return this.$props.projects.length > 1;
		},
	},
	created() {
		this.loading = true;
		Survey.JsonObject.metaData.addProperty("itemvalue", {
			name: "statsColor",
		});
		Survey.StylesManager.applyTheme("bootstrap");

		SurveyAnalytics.VisualizationPanel.haveCommercialLicense = true;
		for (let i = 0; i < this.questionTypesToApplyCustomTextsTableVisualizer.length; i++) {
			const type = this.questionTypesToApplyCustomTextsTableVisualizer[i];
			// Register custom visualizer for the free text question type
			const visualizers = SurveyAnalytics.VisualizationManager.getVisualizersByType(type);
			// arrange visualizers
			const wordCloud = visualizers[0];
			const simpleTable = visualizers[1];

			SurveyAnalytics.VisualizationManager.unregisterVisualizer(type, wordCloud);
			SurveyAnalytics.VisualizationManager.unregisterVisualizer(type, simpleTable);
			SurveyAnalytics.VisualizationManager.registerVisualizer(type, FreeTextQuestionStatisticsCustomVisualizer);
			SurveyAnalytics.VisualizationManager.registerVisualizer(type, wordCloud);
		}
		const fileType = "file";
		const fileVisualizers = SurveyAnalytics.VisualizationManager.getVisualizersByType(fileType);
		if (fileVisualizers && fileVisualizers.length) {
			SurveyAnalytics.VisualizationManager.unregisterVisualizer(fileType, fileVisualizers[0]);
			if (this.showFileTypeQuestionsStatistics !== -1) {
				SurveyAnalytics.VisualizationManager.registerVisualizer(
					fileType,
					FileQuestionStatisticsCustomVisualizer,
				);
			}
		}
		// Set localized title of this visualizer
		SurveyAnalytics.localization.locales["en"]["visualizer_freeTextVisualizer"] = "Responses Table";

		this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
		this.questions = this.survey.getAllQuestions();
		this.getColorsForCrowdSourcingProject();
	},
	mounted() {
		this.listenForVoteClickEvent();
		this.listenForAnnotateClickEvent();
	},
	methods: {
		...mapActions(["get", "post", "handleError", "closeModal"]),
		getColorsForCrowdSourcingProject() {
			this.get({
				url: window.route("api.crowd-sourcing-project.colors.get", this.questionnaire.project_id),
				data: {},
				urlRelative: false,
			}).then((response) => {
				this.colors = response.data;
				this.getQuestionnaireDataAndInitStatistics();
			});
		},
		getQuestionnaireDataAndInitStatistics() {
			Promise.all([
				this.getQuestionnaireResponses(),
				this.getQuestionnaireAnswerVotes(),
				this.getQuestionnaireAnswerAnnotations(),
				this.getQuestionnaireAnswerAdminAnalysisStatuses(),
			]).then((results) => {
				this.responses = results[0];
				this.initStatistics(results[0], results[1], results[2], results[3]);
			});
		},
		getQuestionnaireResponses() {
			const instance = this;
			return new Promise(function callback(resolve, reject) {
				instance
					.get({
						url: window.route(
							"api.questionnaire.responses.get",
							instance.questionnaire.id,
							instance.projectFilter,
						),
						data: {},
						urlRelative: false,
					})
					.then((response) => {
						const answers = response.data.map((response) => {
							return {
								response_id: response.id,
								response_text: JSON.parse(response.response_json_translated ?? response.response_json),
								respondent_user_id: response.user_id,
								project_name: response.project.default_translation.name,
							};
						});
						instance.answersData = response.data;
						resolve(answers);
					})
					.catch((e) => reject(e));
			});
		},
		getQuestionnaireAnswerVotes() {
			return this.get({
				url: window.route("api.questionnaire.answer-votes.get", this.questionnaire.id),
				data: {},
				urlRelative: false,
			}).then((res) => res.data);
		},
		getQuestionnaireAnswerAnnotations() {
			return this.get({
				url: window.route("api.questionnaire.answer-annotations.get", this.questionnaire.id),
				data: {},
				urlRelative: false,
			}).then((res) => res.data);
		},
		getQuestionnaireAnswerAdminAnalysisStatuses() {
			if (this.userCanAnnotateAnswers) {
				return this.get({
					url: window.route("questionnaire.answers-admin-analysis-statuses.get"),
					data: {},
					urlRelative: false,
				}).then((res) => res.data);
			}
		},
		initStatistics(answers, answerVotes, answerAnnotations, adminAnalysisStatuses) {
			// remove from the questions array the questions that should not be displayed in the statistics
			const questionsWithNoCustomVisualizer = this.questions.filter(
				(question) => this.shouldDrawStatistics(question) && !this.questionHasCustomVisualizer(question),
			);
			const questionsWithCustomVisualizer = this.questions.filter(
				(question) => this.shouldDrawStatistics(question) && this.questionHasCustomVisualizer(question),
			);
			const questionsWithNoCustomVisualizerResponses = answers.map((answer) => answer.response_text);
			const questionsWithCustomVisualizerResponses = answers;

			this.answerAnnotationAdminReviewStatuses = adminAnalysisStatuses;
			this.numOfVotesByCurrentUser = answerVotes.filter((vote) => vote.voter_user_id === this.userId).length;
			AnswersData.answerVotes = answerVotes;
			AnswersData.answerAnnotations = answerAnnotations;
			AnswersData.userId = this.userId;
			AnswersData.userCanAnnotateAnswers = this.userCanAnnotateAnswers;
			AnswersData.numberOfVotesForQuestionnaire = this.questionnaire.max_votes_num;
			AnswersData.languageResources = window.trans("statistics");

			for (let i = 0; i < this.questions.length; i++) {
				const colors = this.convertColorNamesToColorCodes(this.getColorsForQuestion(this.questions[i]));
				if (colors.length) {
					if (this.questions[i].otherItem) {
						colors.unshift("blue");
					}
					this.statsPanelIndexToColors.set(i, colors);
				}
			}

			this.visualizeQuestions(
				questionsWithNoCustomVisualizer,
				questionsWithNoCustomVisualizerResponses,
				"survey-statistics-container_default_visualizer",
			);
			this.visualizeQuestions(
				questionsWithCustomVisualizer,
				questionsWithCustomVisualizerResponses,
				"survey-statistics-container_custom_visualizer",
			);
			this.loading = false;
		},
		visualizeQuestions(questionsWithNoCustomVisualizer, questionsWithNoCustomVisualizerResponses, elementId) {
			const visPanel = new SurveyAnalytics.VisualizationPanel(
				questionsWithNoCustomVisualizer,
				questionsWithNoCustomVisualizerResponses,
				{
					labelTruncateLength: -1,
					allowDynamicLayout: false,
					allowSelection: false,
				},
			);
			visPanel.showHeader = false;

			const instance = this;
			visPanel.visualizers.forEach((visualizer) => {
				if (!visualizer.onAnswersDataReady) return;
				visualizer.onAnswersDataReady.add((sender, options) => {
					if (instance.statsPanelIndexToColors.has(sender.options.index))
						options.colors = instance.statsPanelIndexToColors.get(sender.options.index);
				});
			});
			visPanel.render(document.getElementById(elementId));
		},
		initializeQuestionnaireResponsesReport() {
			const panelEl = document.getElementById("questionnaire-responses-report");
			panelEl.innerHTML = "";
			Tabulator.haveCommercialLicense = true;
			const answersForSurveyTabulator = this.answersData.map((response) => JSON.parse(response.response_json));
			const surveyAnalyticsTabulator = new Tabulator(this.survey, answersForSurveyTabulator, {
				downloadButtons: ["csv"],
			});
			surveyAnalyticsTabulator.render(panelEl);
		},
		questionHasCustomVisualizer(question) {
			return this.questionTypesToApplyCustomTextsTableVisualizer.includes(question.getType());
		},
		shouldDrawStatistics(question) {
			const caseWhenQuestionIsSensitiveAndUserIsNotAdmin =
				!this.userCanAnnotateAnswers && question.title.includes("please indicate your email");
			if (question.getType() === "file") return this.showFileTypeQuestionsStatistics !== -1;
			return question.getType().toLowerCase() !== "html" && !caseWhenQuestionIsSensitiveAndUserIsNotAdmin;
		},
		getColorsForQuestion(question) {
			let choices = [];
			if (question.choices) choices = question.choices;
			else if (question.columns) choices = question.columns;
			else return [];

			return choices.map((choice) => choice.statsColor);
		},
		convertColorNamesToColorCodes(colorNames) {
			const colorCodes = [];
			for (let i = 0; i < colorNames.length; i++) {
				const color = this.colors.find((color) => color.color_name === colorNames[i]);
				if (color) colorCodes.push(color.color_code);
			}
			return colorCodes;
		},
		listenForVoteClickEvent() {
			const instance = this;
			$(document).on("click", "body .vote-btn", function () {
				const actionIsUpvote = $(this).hasClass("upvote");
				const userHasAlreadyUpVoted = $(this).hasClass("user-upvoted");
				const element = $(this);
				if (instance.userId) {
					if (
						!userHasAlreadyUpVoted &&
						actionIsUpvote &&
						instance.numOfVotesByCurrentUser >= instance.questionnaire.max_votes_num
					)
						return instance.displayMaxVotesMessage();
					instance.performVoteCall(
						element.data("question-name"),
						parseInt(element.data("respondent-user-id")),
						actionIsUpvote,
					);
					if (actionIsUpvote) {
						if (userHasAlreadyUpVoted) instance.numOfVotesByCurrentUser -= 1;
						else instance.numOfVotesByCurrentUser += 1;
						// if the user has already upvoted, subtract one
						// if the user has downvoted the same question, subtract one from downvotes and cancel the downvote class
						instance.updateCountElement(element, "user-upvoted", "user-downvoted", "downvote");
						element.toggleClass("user-upvoted");
					} else {
						// if the user has already downvoted, subtract one
						// if the user has upvoted the same question, subtract one from downvotes and cancel the downvote class
						instance.updateCountElement(element, "user-downvoted", "user-upvoted", "upvote");
						element.toggleClass("user-downvoted");
					}
					const remainingVotes = instance.questionnaire.max_votes_num - instance.numOfVotesByCurrentUser;
					let votesWord = window.trans("voting.votes_remaining_singular");
					if (remainingVotes > 1) votesWord = window.trans("voting.votes_remaining_plural");
					const message = window.trans("voting.votes_remaining", {
						votes: remainingVotes,
						votesWord: votesWord,
					});
					showToast(message, "#28a745", "bottom-right");
				} else instance.displayLoginPrompt();
			});
		},
		listenForAnnotateClickEvent() {
			const instance = this;
			$(document).on("click", "body .annotate-btn", function () {
				let adminReviewStatusId = parseInt($(this).attr("data-annotation-admin-review-status-id"));
				let annotationText = $(this).attr("data-annotation");
				let adminReviewComment = $(this).attr("data-annotation-admin-review-comment");
				if (!adminReviewStatusId) adminReviewStatusId = instance.answerAnnotationAdminReviewStatuses[0].id;
				if (annotationText === "null") annotationText = null;
				if (adminReviewComment === "null") adminReviewComment = null;

				instance.annotation = {
					annotation_text: annotationText,
					admin_review_status_id: adminReviewStatusId,
					admin_review_comment: adminReviewComment,
					question_name: $(this).data("question"),
					respondent_user_id: $(this).data("respondent"),
				};
				instance.annotationModalOpen = true;
			});
		},
		performVoteCall(questionName, respondentUserId, upvote) {
			this.post({
				url: window.route("api.questionnaire.answer-votes.store"),
				data: {
					questionnaire_id: this.questionnaire.id,
					question_name: questionName,
					respondent_user_id: respondentUserId,
					voter_user_id: this.userId,
					upvote: upvote,
				},
				urlRelative: false,
			});
		},
		displayLoginPrompt() {
			this.signInModalOpen = true;
		},
		displayMaxVotesMessage() {
			this.maxVotesModalOpen = true;
		},
		updateCountElement(element, className, oppositeClassName, oppositeButtonClassName) {
			const countEl = element.find(".count:first");
			let count = parseInt(countEl.html());
			if (element.hasClass(className)) {
				count -= 1;
			} else {
				count += 1;
			}
			countEl.html(count);

			const parent = element.closest(".reaction-buttons");
			const oppositeButtonEl = parent.find("." + oppositeButtonClassName + ":first");
			if (oppositeButtonEl && oppositeButtonEl.hasClass(oppositeClassName)) {
				oppositeButtonEl.removeClass(oppositeClassName);
				const countEl = oppositeButtonEl.find(".count:first");
				const count = parseInt(countEl.html()) - 1;
				countEl.html(count);
			}
		},
		getSignInUrl() {
			return window.route("login", window.Laravel.locale) + "?redirectTo=" + window.location.href;
		},
		saveAnnotation() {
			this.annotationSaveLoading = true;
			this.post({
				url: window.route("api.questionnaire.answer-annotations.store"),
				data: {
					questionnaire_id: this.questionnaire.id,
					question_name: this.annotation.question_name,
					respondent_user_id: this.annotation.respondent_user_id,
					annotator_user_id: this.userId,
					annotation_text: this.annotation.annotation_text,
					admin_review_status_id: this.annotation.admin_review_status_id,
					admin_review_comment: this.annotation.admin_review_comment,
				},
				urlRelative: false,
			}).then(() => {
				this.annotationSaveLoading = false;
				this.annotationModalOpen = false;
				const cellElement = $(
					"#" + "answer_" + this.annotation.question_name + "_" + this.annotation.respondent_user_id,
				);
				const annotationElement = cellElement.find(".annotation-wrapper");
				if (this.annotation.annotation_text) {
					if (annotationElement.length !== 0)
						annotationElement.find(".annotation-text").html(this.annotation.annotation_text);
					else {
						cellElement
							.find(".annotation-button")
							.after(
								'<div class="annotation-wrapper"><b>Comment by the admin:</b><p class="annotation-text">' +
									this.annotation.annotation_text +
									"</p></div><b>Original answer:</b>",
							);
					}
				}
				cellElement.find(".annotate-btn").attr("data-annotation", this.annotation.annotation_text);
				cellElement
					.find(".annotate-btn")
					.attr("data-annotation-admin-review-status-id", this.annotation.admin_review_status_id);
				cellElement
					.find(".annotate-btn")
					.attr("data-annotation-admin-review-comment", this.annotation.admin_review_comment);
				cellElement
					.find(".annotate-btn")
					.append('<i class="fa fa-check" title="This answer has been reviewed by a moderator"></i>');
			});
		},
		deleteAnnotation() {
			this.annotationDeleteLoading = true;
			this.post({
				url: window.route("questionnaire.answer-annotations.destroy"),
				data: {
					questionnaire_id: this.questionnaire.id,
					question_name: this.annotation.question_name,
					respondent_user_id: this.annotation.respondent_user_id,
				},
				urlRelative: false,
			}).then(() => {
				this.annotationDeleteLoading = false;
				this.annotationModalOpen = false;
				const cellElement = $(
					"#" + "answer_" + this.annotation.question_name + "_" + this.annotation.respondent_user_id,
				);
				const annotationElement = cellElement.find(".annotation-wrapper");
				cellElement.find(".fa-check").remove();
				if (annotationElement.length) annotationElement.remove();
				this.annotation = {
					annotation_text: "",
				};
			});
		},
		onFilterProject(event) {
			window.location.href = window.route(
				"questionnaire.statistics",
				window.Laravel.locale,
				this.questionnaire.id,
				event.target.value,
			);
		},
		showResponsesTable() {
			this.initializeQuestionnaireResponsesReport(this.responses);
			this.responsesTableShown = true;
		},
	},
});
</script>

<style lang="scss">
@import "survey-jquery/modern.min.css";
@import "survey-analytics/survey.analytics.min.css";
@import "survey-analytics/survey.analytics.tabulator.min.css";
@import "tabulator-tables/dist/css/tabulator.min.css";
@import "../../../sass/questionnaire/statistics";
</style>
