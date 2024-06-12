import * as Survey from "survey-knockout";
import { Tabulator } from "survey-analytics/survey.analytics.tabulator.js";
import _ from "lodash";
import "datatables.net-buttons-bs4";
import "datatables.net-buttons/js/buttons.html5.mjs";

(function () {
	let respondentsTable, questionnaire, answers, survey, loader;

	let checkForURLSearchParams = function () {
		let searchParams = new URLSearchParams(window.location.search);
		const questionnaireId = searchParams.get("questionnaireId");
		if (questionnaireId) {
			$("select[name=questionnaire_id]").val(questionnaireId);
			triggerSearch();
		}
	};

	let updateURLSearchParams = function (criteria) {
		let searchParams = new URLSearchParams(window.location.search);
		let newURL = "";
		if (searchParams.has("questionnaireId")) {
			newURL = location.href.replace(
				"questionnaireId=" + searchParams.get("questionnaireId"),
				"questionnaireId=" + criteria.questionnaireId,
			);
		} else {
			newURL = location.href += "?questionnaireId=" + criteria.questionnaireId;
		}

		if (window.history.replaceState) {
			window.history.replaceState({}, null, newURL);
		}
	};

	let searchBtnHandler = function () {
		$("#searchBtn").on("click", function () {
			let criteria = {};
			criteria.questionnaireId = $("select[name=questionnaire_id]").val();
			if (criteria.questionnaireId) updateURLSearchParams(criteria);
			getReportsForCriteria(criteria);
		});
	};

	let triggerSearch = function () {
		$("#searchBtn").trigger("click");
	};

	let viewResponseBtnHandler = function () {
		$("body").on("click", ".response-btn", function () {
			const respondentUserId = $(this).data("respondentUserId");
			const respondentUserData = $(this).data("respondentUserData");
			const answer = getResponseJSONByRespondentId(respondentUserId);
			if (answer) {
				$("#respondent-answers-modal-title").html(respondentUserData);
				survey.data = answer;
				window.$("#respondent-answers-modal").modal();
			}
		});
	};

	let deleteResponseBtnHandler = function () {
		const body = $("body");
		body.on("click", ".delete-response-btn", function () {
			const questionnaireResponseId = $(this).data("questionnaireResponseId");
			$("input[name=questionnaire_response_id]").val(questionnaireResponseId);
			window.$("#delete-response-modal").modal();
		});

		body.on("click", "#delete-response-form-btn", function () {
			const questionnaireResponseId = $("input[name=questionnaire_response_id]").val();
			const loader = $("#delete-response-loader");
			const errorEl = $("#delete-response-error");
			const swal = import("bootstrap-sweetalert");
			const headers = {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
			};
			$.ajax({
				headers: headers,
				method: "POST",
				url: window.route("questionnaire_response.destroy"),
				cache: false,
				data: {
					questionnaire_response_id: questionnaireResponseId,
				},
				beforeSend: function () {
					loader.removeClass("d-none");
					errorEl.addClass("d-none");
				},
				success: function () {
					loader.addClass("d-none");
					const tableRow = $("#questionnaire_response_" + questionnaireResponseId);
					respondentsTable.row(tableRow).remove().draw();

					window.$("#delete-response-modal").modal("hide");
					swal({
						title: "Response deleted!",
						text: "",
						type: "success",
						confirmButtonClass: "btn-success",
						confirmButtonText: "OK",
					});
				},
				error: function (error) {
					loader.addClass("d-none");
					errorEl.removeClass("d-none");
					errorEl.html(error.responseJSON.data);
				},
			});
		});
	};

	let getResponseJSONByRespondentId = function (id) {
		for (let i = 0; i < answers.length; i++)
			if (answers[i].user_id === id) return JSON.parse(answers[i].response_json);
	};

	let getReportsForCriteria = function (criteria) {
		const errorEl = $("#errorMsg");
		$.ajax({
			method: "GET",
			url: $("#searchBtn").data("url"),
			cache: false,
			data: criteria,
			beforeSend: function () {
				$("#results").html("");
				loader.removeClass("d-none");
				errorEl.addClass("d-none");
			},
			success: function (response) {
				parseSuccessData(response);
			},
			error: function (error) {
				loader.addClass("d-none");
				errorEl.removeClass("d-none");
				errorEl.html(error.responseJSON.data);
			},
		});
	};

	let parseSuccessData = function (response) {
		const resultsEl = $("#results");
		resultsEl.html("");
		$("#errorMsg").addClass("d-none");
		resultsEl.html(response.data.view);
		questionnaire = response.data.questionnaire;
		answers = response.data.responses;
		survey = new Survey.Model(JSON.parse(questionnaire.questionnaire_json));
		survey.mode = "display";
		survey.render("respondent-answers-panel");
		initializeDataTables();
		initializeQuestionnaireResponsesReport();
		loader.addClass("d-none");
	};

	let initializeDataTables = function () {
		respondentsTable = $("#respondentsTable").DataTable({
			paging: true,
			searching: true,
			responsive: true,
			pageLength: 25,
			layout: {
				topStart: {
					buttons: [
						{
							extend: "csvHtml5",
							text: "CSV",
							title:
								"Questionnaire_Respondents_" +
								$("select[name=questionnaire_id]").val() +
								"_" +
								new Date().getTime(),
							exportOptions: {
								modifier: {
									search: "none",
								},
							},
						},
					],
				},
			},
		});
	};

	let initializeQuestionnaireResponsesReport = function () {
		let panelEl = document.getElementById("questionnaire-responses-report");
		panelEl.innerHTML = "";
		Tabulator.haveCommercialLicense = true;
		const answersForSurveyTabulator = _.map(answers, "response_json").map(JSON.parse);
		const surveyAnalyticsTabulator = new Tabulator(survey, answersForSurveyTabulator, {
			downloadButtons: ["csv"],
		});
		surveyAnalyticsTabulator.render(panelEl);
	};

	let init = function () {
		loader = $("#loader");
		Survey.StylesManager.applyTheme("modern");

		searchBtnHandler();
		viewResponseBtnHandler();
		deleteResponseBtnHandler();
		checkForURLSearchParams();
	};

	$(document).ready(function () {
		init();
	});
})();
