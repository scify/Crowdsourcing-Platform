import * as Survey from "survey-jquery";
import { Tabulator } from "survey-analytics/survey.analytics.tabulator.js";
import "datatables.net-buttons-bs4";
import "datatables.net-buttons/js/buttons.html5.mjs";

(function () {
	let respondentsTable;
	let questionnaire;
	let answers;
	let survey;
	let loader;

	const checkForURLSearchParams = function () {
		const searchParams = new URLSearchParams(window.location.search);
		const questionnaireId = searchParams.get("questionnaireId");
		if (questionnaireId) {
			$("select[name=questionnaire_id]").val(questionnaireId);
			triggerSearch();
		}
	};

	const updateURLSearchParams = function (criteria) {
		const searchParams = new URLSearchParams(window.location.search);
		let newURL;
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

	const searchBtnHandler = function () {
		$("#searchBtn").on("click", function () {
			const criteria = {};
			criteria.questionnaireId = $("select[name=questionnaire_id]").val();
			if (criteria.questionnaireId) updateURLSearchParams(criteria);
			getReportsForCriteria(criteria);
		});
	};

	const triggerSearch = function () {
		$("#searchBtn").trigger("click");
	};

	const viewResponseBtnHandler = function () {
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

	const deleteResponseBtnHandler = function () {
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

	const getResponseJSONByRespondentId = function (id) {
		for (let i = 0; i < answers.length; i++)
			if (answers[i].user_id === id) return JSON.parse(answers[i].response_json);
	};

	const getReportsForCriteria = function (criteria) {
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

	const parseSuccessData = function (response) {
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

	const initializeDataTables = function () {
		respondentsTable = $("#respondentsTable").DataTable({
			paging: true,
			searching: true,
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

	const initializeQuestionnaireResponsesReport = function () {
		const panelEl = document.getElementById("questionnaire-responses-report");
		panelEl.innerHTML = "";
		Tabulator.haveCommercialLicense = true;
		const answersForSurveyTabulator = answers.map(answer => JSON.parse(answer.response_json));
		const surveyAnalyticsTabulator = new Tabulator(survey, answersForSurveyTabulator, {
			downloadButtons: ["csv"],
		});
		surveyAnalyticsTabulator.render(panelEl);
	};

	const init = function () {
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
