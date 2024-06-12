(function () {
	let init = function () {
		changeQuestionnaireStatusBtnHandler();
		initializeDataTable();
	};

	let changeQuestionnaireStatusBtnHandler = function () {
		$("body").on("click", ".change-status", updateFieldsInChangeStatusModal);
	};

	let updateFieldsInChangeStatusModal = function () {
		const parent = $(this).closest("tr");
		const questionnaireId = parent.data("id");
		const title = parent.data("title");
		const statusId = parent.data("status");
		$("#questionnaire-title").html(title);
		$("#questionnaire-id").val(questionnaireId);
		$("#status-select").val(statusId);
		$("#comments").val("");
	};

	let initializeDataTable = function () {
		setTimeout(function () {
			let table = $("#questionnaires-table");
			table.DataTable({
				destroy: true,
				paging: true,
				responsive: true,
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
