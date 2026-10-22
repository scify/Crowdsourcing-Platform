import { VisualizerBase } from "survey-analytics";

function renderHeader(table) {
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
	const answers = visualizer.surveyData;
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
			' <i class="fas fa-external-link-alt ms-2"></i></a>';

		tr.appendChild(td0);
		tbody.appendChild(tr);
	});
	table.appendChild(tbody);
}

function renderTable(contentContainer, visualizer) {
	const div = document.createElement("div");
	div.id = visualizer.question.name + "_answer_container";
	contentContainer.appendChild(div);

	const table = document.createElement("table");
	table.className = "w-100 table table-striped custom-texts-table";
	renderHeader(table);
	renderRows(table, visualizer);
	const container = document.createElement("div");

	contentContainer.appendChild(container);
	container.appendChild(table);
	contentContainer.className += " custom-texts-table-container";
	const columns = [{ width: "100%" }];
	const options = {
		destroy: true,
		paging: true,
		searching: false,
		columns: columns,
	};
	options.buttons = [];
	$(table).DataTable(options);
}

/**
 * Lists the uploaded files of a "file" question as links (survey-analytics custom visualizer).
 */
export default class FileQuestionStatisticsCustomVisualizer extends VisualizerBase {
	constructor(question, data, options) {
		super(question, data, options, "fileVisualizer");
	}

	renderContent(contentContainer) {
		renderTable(contentContainer, this);
		this.afterRender(contentContainer);
	}
}
