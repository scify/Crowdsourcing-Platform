import { Model } from "survey-core";
import "survey-js-ui";
import { DefaultLight } from "survey-core/themes";

(function () {
	const initializeDataTable = function () {
		const usersTable = $("#responsesTable");
		if (usersTable.length)
			usersTable.DataTable({
				paging: true,
				searching: true,
				pageLength: 10,
				/* No ordering applied by DataTables during initialisation */
				order: [],
				columns: [{ width: "20%" }, { width: "20%" }, { width: "40%" }, { width: "10%" }, { width: "10%" }],
			});

		const proposedSolutionTable = $("#proposedSolutionsTable");
		if (proposedSolutionTable.length)
			proposedSolutionTable.DataTable({
				paging: true,
				searching: true,
				pageLength: 10,
				/* No ordering applied by DataTables during initialisation */
				order: [],
				columns: [{ width: "20%" }, { width: "20%" }, { width: "40%" }, { width: "10%" }, { width: "10%" }],
			});
	};

	const viewResponseHandler = function () {
		$("body").on("click", ".viewResponseBtn", function () {
			const responseId = $(this).data("responseid");
			showResponse(responseId);
		});
	};

	const showResponse = function (responseId) {
		const response = getResponseById(responseId);
		const responseModal = window.$("#questionnaireResponseModal");
		if (response) {
			responseModal.find("#questionnaireTitle").html(response.title);
			// The v3 UI keeps a virtual DOM per container, so render every response
			// into a fresh child element instead of reusing a cleared container.
			const container = document.getElementById("questionnaireResponse");
			container.innerHTML = "";
			const surveyEl = document.createElement("div");
			container.appendChild(surveyEl);
			const survey = new Model(JSON.parse(response.questionnaire_json));
			survey.applyTheme(DefaultLight);
			survey.data = JSON.parse(response.response_json);
			survey.mode = "display";
			survey.locale = response.language_code;
			survey.render(surveyEl);
			window.bootstrap.Modal.getOrCreateInstance(document.getElementById("questionnaireResponseModal")).show();
		}
	};

	const getResponseById = function (responseId) {
		for (let i = 0; i < responses.length; i++) {
			if (responses[i].questionnaire_response_id === responseId) {
				return responses[i];
			}
		}
	};

	const init = function () {
		$(document).ready(function () {
			initializeDataTable();
			viewResponseHandler();
		});
	};

	$(document).ready(function () {
		init();
	});
})();
