"use strict";
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
// Register the plugin to all charts:
Chart.register(ChartDataLabels);

import { createApp } from "vue";
import store from "../store/store";

import QuestionnaireStatistics from "../vue-components/questionnaire/QuestionnaireStatistics.vue";
import DOMPurify from "dompurify";

const app = createApp({
	components: {
		QuestionnaireStatistics,
	},
});

// Register the "sane-html" directive globally
app.directive("sane-html", {
	updated(el, binding) {
		el.innerHTML = DOMPurify.sanitize(binding.value);
	},
	mounted(el, binding) {
		el.innerHTML = DOMPurify.sanitize(binding.value);
	},
});

app.use(store);
app.mount("#app");

(function () {
	const init = function () {
		if (viewModel.questionnaireResponseStatistics.totalResponses) initQuestionnaireResponsesChart();

		if (viewModel.numberOfResponsesPerLanguage.data.length > 1) initQuestionnaireResponsesPerLanguageChart();
		printPageBtnHandler();
	};

	const initQuestionnaireResponsesChart = function () {
		if (!document.getElementById("responsesChart")) return;

		const ctx = document.getElementById("responsesChart").getContext("2d");
		const colors = getRandomColors(2);

		if (!viewModel.questionnaireResponseStatistics.totalResponsesColor)
			viewModel.questionnaireResponseStatistics.totalResponsesColor = colors[0];

		if (!viewModel.questionnaireResponseStatistics.goalResponsesColor)
			viewModel.questionnaireResponseStatistics.goalResponsesColor = colors[1];
		const data = {
			datasets: [
				{
					data: [
						viewModel.questionnaireResponseStatistics.goalResponses,

						viewModel.questionnaireResponseStatistics.totalResponses,
					],
					backgroundColor: [
						viewModel.questionnaireResponseStatistics.goalResponsesColor,

						viewModel.questionnaireResponseStatistics.totalResponsesColor,
					],
					border: {
						width: 1,
					},
				},
			],

			labels: [window.trans("statistics.goal_responses"), window.trans("statistics.actual_responses")],
		};

		createChart(ctx, data, "pie");
	};

	const initQuestionnaireResponsesPerLanguageChart = function () {
		const element = document.getElementById("responsesPerLanguageChart");
		if (!element) return;
		const ctx = element.getContext("2d");

		const colors = getRandomColors(viewModel.numberOfResponsesPerLanguage.data.length);

		for (let i = 0; i < viewModel.numberOfResponsesPerLanguage.data.length; i++) {
			if (!viewModel.numberOfResponsesPerLanguage.data[i].color)
				viewModel.numberOfResponsesPerLanguage.data[i].color = colors[i];
		}
		const data = {
			datasets: [
				{
					data: viewModel.numberOfResponsesPerLanguage.data.map((item) => item.num_responses),
					backgroundColor: viewModel.numberOfResponsesPerLanguage.data.map((item) => item.color),
				},
			],

			labels: viewModel.numberOfResponsesPerLanguage.data.map((item) => item.language_name),
		};

		createChart(ctx, data, "bar");
	};

	const createChart = function (canvasContext, data, chartType) {
		const options = getChartCommonOptions(chartType);
		if (chartType === "pie") options.legend = { display: true };
		const config = {
			type: chartType,
			data: data,
			options: options,
		};
		if (chartType === "bar" || chartType === "horizontalBar") config.borderWidth = 1;
		return new Chart(canvasContext, config);
	};

	const getChartCommonOptions = function (chartType) {
		const options = {
			responsive: true,
			legend: { display: false },
			tooltips: {
				enabled: true,
			},
			offset: true,
			plugins: {
				datalabels: {
					formatter: (value, ctx) => getResponsesPercentageDataLabels(value, ctx),
					color: "#000",
					textAlign: "center",
					labels: {
						title: {
							font: {
								weight: "bold",
								size: 14,
							},
						},
					},
				},
			},
		};

		switch (chartType) {
			case "horizontalBar":
				options.scales = {
					yAxes: [
						{
							gridLines: {
								offsetGridLines: true,
							},
						},
					],
					xAxes: [
						{
							ticks: {
								beginAtZero: true,
							},
						},
					],
				};
				options.indexAxis = "y";
				break;
			case "bar":
				options.scales = {
					xAxes: [
						{
							gridLines: {
								offsetGridLines: true,
							},
						},
					],
					yAxes: [
						{
							ticks: {
								beginAtZero: true,
							},
						},
					],
				};
				options.indexAxis = "x";
				break;
		}
		return options;
	};

	const getResponsesPercentageDataLabels = function (value, ctx) {
		let sum = 0;
		const dataArr = ctx.chart.data.datasets[0].data;
		dataArr.map((data) => {
			sum += data;
		});
		const percentage = ((value * 100) / sum).toFixed(2) + "%";
		return value + " responses\n" + percentage;
	};

	const getRandomColors = function (num) {
		const array = [
			"#ef5350",
			"#ab47bc",
			"#5c6bc0",
			"#66bb6a",
			"#ffa726",
			"#8d6e63",
			"#123456",
			"#ffee58",
			"#42a5f5",
			"#26a69a",
			"#ec407a",
			"#78909c",
			"#827717",
			"#8D6E63",
			"#607D8B",
			"#ff1744",
			"#00C853",
			"#FFFF00",
		];
		// Copy the array and sort the copy
		const sortedArray = array.slice().sort(() => Math.random() - 0.5);

		// Return the first 'num' elements of the sorted array
		return sortedArray.slice(0, num);
	};

	const printPageBtnHandler = function () {
		$("#print-page").click(function () {
			window.print();
		});
	};

	$(document).ready(function () {
		setTimeout(function () {
			init();
		}, 3000);
	});
})();
