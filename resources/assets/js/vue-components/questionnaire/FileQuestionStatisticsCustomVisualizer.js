import * as SurveyAnalytics from "survey-analytics";

function FileQuestionStatisticsCustomVisualizer(question, data) {
	function renderHeader(table, visualizer) {
		const header = document.createElement("thead");
		const tr = document.createElement("tr");
		const header0 = document.createElement("th");
		header0.innerHTML = "Answer";
		tr.appendChild(header0);
		header.appendChild(tr);
		table.appendChild(header);
	}

	function renderRows(table, visualizer) {
		const tbody = document.createElement("tbody");
		const questionName = visualizer.question.name;
		const answers = visualizer.dataProvider.data;
		answers.forEach(function (answer) {
			const response = answer[questionName];
			if (!response || !response.length || !response[0]) return;
			const fileName = response[0].name;
			const fileURL = response[0].content;
			const tr = document.createElement("tr");
			const td0 = document.createElement("td");

			td0.innerHTML =
				"<a class='file-link' href=\"" +
				fileURL +
				'" target="_blank" rel="nofollow">' +
				fileName +
				' <i class="fas fa-external-link-alt ml-2"></i></a>';

			tr.appendChild(td0);
			tbody.appendChild(tr);
		});
		table.appendChild(tbody);
	}

	const renderContent = function (contentContainer, visualizer) {
		const div = document.createElement("div");
		div.id = question.name + "_answer_container";
		contentContainer.appendChild(div);

		const table = document.createElement("table");
		table.className = "sa__matrix-table w-100 table table-striped custom-texts-table";
		renderHeader(table, visualizer);
		renderRows(table, visualizer);
		const container = document.createElement("div");

		contentContainer.appendChild(container);
		container.appendChild(table);
		contentContainer.className += " custom-texts-table-container";
		const columns = [{ width: "100%" }];
		const options = {
			destroy: true,
			paging: true,
			responsive: true,
			searching: false,
			columns: columns,
			dom: "Bfrtip",
		};
		options.buttons = [];
		$(table).DataTable(options);
	};

	return new SurveyAnalytics.VisualizerBase(
		question,
		data,
		{
			renderContent: renderContent,
		},
		"fileVisualizer",
	);
}

export default FileQuestionStatisticsCustomVisualizer;
