(function () {
	const init = function () {
		changeQuestionnaireStatusBtnHandler();
		initializeDataTable();
	};

	const changeQuestionnaireStatusBtnHandler = function () {
		$("body").on("click", ".change-status", updateFieldsInChangeStatusModal);
	};

	const updateFieldsInChangeStatusModal = function () {
		const parent = $(this).closest("tr");
		const questionnaireId = parent.data("id");
		const title = parent.data("title");
		const statusId = parent.data("status");
		$("#questionnaire-title").html(title);
		$("#questionnaire-id").val(questionnaireId);
		$("#status-select").val(statusId);
		$("#comments").val("");
	};

	const initializeDataTable = function () {
		setTimeout(function () {
			const table = $("#questionnaires-table");
			table.DataTable({
				destroy: true,
				paging: true,
				searching: true,
				columns: [
					{ width: "5%" },
					{ width: "30%" },
					{ width: "10%" },
					{ width: "10%" },
					{ width: "20%" },
					{ width: "10%" },
					{ width: "5%" },
					{ width: "10%" },
				],
			});
		}, 1000);
	};

	$(document).ready(function () {
		init();
	});
})();
