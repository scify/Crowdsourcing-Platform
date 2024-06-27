import * as Survey from "survey-knockout";

(function () {
	let survey;
	const initializeDataTable = function () {
		const usersTable = $("#responsesTable");
		if (usersTable.length)
			usersTable.DataTable({
				paging: true,
				searching: true,
				responsive: true,
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
			responseModal.find("#questionnaireResponse").html("");
			responseModal.find("#questionnaireTitle").html(response.title);
			survey.setJsonObject(JSON.parse(response.questionnaire_json));
			survey.data = JSON.parse(response.response_json);
			survey.mode = "display";
			survey.render("questionnaireResponse");
			survey.locale = response.language_code;
			responseModal.modal();
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
		Survey.StylesManager.applyTheme("modern");
		survey = new Survey.Model();
		$(document).ready(function () {
			initializeDataTable();
			viewResponseHandler();
		});
	};

	$(document).ready(function () {
		init();
	});
})();
