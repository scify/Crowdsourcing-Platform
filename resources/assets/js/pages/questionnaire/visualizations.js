'use strict';
import Chart from 'chart.js';

(function () {
    let init = function () {
        initQuestionnaireResponsesChart();
        initQuestionnaireResponsesPerLanguageChart();
        initQuestionResponsesCharts();
        printPageBtnHandler();
    };

    let initQuestionnaireResponsesChart = function () {
        let ctx = document.getElementById('responsesChart').getContext("2d");

        const data = {
            datasets: [{
                data: [
                    viewModel.questionnaireResponseStatistics.goalResponses,
                    viewModel.questionnaireResponseStatistics.totalResponses
                ],
                backgroundColor: getRandomColors(2),
                borderWidth: 1
            }],

            labels: [
                'Goal Responses',
                'Actual Responses'
            ]
        };

        createChart(ctx, data, 'pie');
    };

    let initQuestionnaireResponsesPerLanguageChart = function () {
        let ctx = document.getElementById('responsesPerLanguageChart').getContext("2d");
        for(let i = 0; i < viewModel.numberOfResponsesPerLanguage.data.length; i++) {
            if(!viewModel.numberOfResponsesPerLanguage.data[i].color)
                viewModel.numberOfResponsesPerLanguage.data[i].color = getRandomColors(1)[0];
        }
        const data = {
            datasets: [{
                data: _.map(viewModel.numberOfResponsesPerLanguage.data, 'num_responses'),
                backgroundColor: _.map(viewModel.numberOfResponsesPerLanguage.data, 'color')
            }],

            labels: _.map(viewModel.numberOfResponsesPerLanguage.data, 'language_name')
        };

        createChart(ctx, data, 'bar');
    };

    let initQuestionResponsesCharts = function () {
        for (let i = 0; i < viewModel.statisticsPerQuestion.length; i++) {
            const questionStatisticsObj = viewModel.statisticsPerQuestion[i];
            switch (questionStatisticsObj.question_type) {
                case 'fixed_choices':
                    let canvasElement = $('.questionResponsesChart[data-question-id=' +
                        questionStatisticsObj.question_id + ']')[0];
                    createChartForFixedChoiceQuestionStatistics(canvasElement, questionStatisticsObj.statistics);
                    break;
                case 'free_text':
                    let dataTableElement = $('.questionResponsesTable[data-question-id=' +
                        questionStatisticsObj.question_id + ']');
                    createDataTableForFreeTextQuestionStatistics(dataTableElement, questionStatisticsObj);
                    break;
            }
        }
    };

    let createChartForFixedChoiceQuestionStatistics = function (canvasElement, questionStatistics) {
        let ctx = canvasElement.getContext("2d");
        for(let i = 0; i < questionStatistics.length; i++) {
            if(!questionStatistics[i].color)
                questionStatistics[i].color = getRandomColors(1)[0];
        }
        const data = {
            datasets: [{
                data: _.map(questionStatistics, 'num_responses'),
                backgroundColor: _.map(questionStatistics, 'color')
            }],

            labels: _.map(questionStatistics, 'answer_title')
        };

        createChart(ctx, data, 'horizontalBar');
    };

    let createDataTableForFreeTextQuestionStatistics = function (dataTableElement, questionStatistics) {

        let dataTableOptions = {
            "order": [[ 1, "desc" ]],
            destroy: true,
            "paging": true,
            "responsive": true,
            "searching": true,
            "columns": [
                {"width": "70%"},
                {"width": "30%"}
            ],
        };
        dataTableElement.DataTable(dataTableOptions);
    };

    let createChart = function (canvasContext, data, chartType) {
        let options = getChartCommonOptions(chartType);
        if (chartType === 'pie')
            options.legend = {display: true};
        return new Chart(canvasContext, {
            type: chartType,
            data: data,
            options: options
        });
    };

    let getChartCommonOptions = function (chartType) {
        let options = {
            legend: {display: false},
            tooltips: {
                enabled: true
            },
            offset: true,
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => getResponsesPercentageDataLabels(value, ctx),
                    color: '#000',
                    textAlign: 'center',
                    labels: {
                        title: {
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    }
                }
            }
        };

        switch (chartType) {
            case 'horizontalBar':
                options.scales = {
                    yAxes: [{
                        gridLines: {
                            offsetGridLines: true
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                };
                break;
            case 'bar':
                options.scales = {
                    xAxes: [{
                        gridLines: {
                            offsetGridLines: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                };
                break;
        }
        return options;
    };

    let getResponsesPercentageDataLabels = function (value, ctx) {
        let sum = 0;
        let dataArr = ctx.chart.data.datasets[0].data;
        dataArr.map(data => {
            sum += data;
        });
        const percentage = (value * 100 / sum).toFixed(2) + "%";
        return value + ' responses\n' + percentage;
    };

    let getRandomColors = function (num) {
        const array = [
            "#ef5350", "#ab47bc", "#5c6bc0",
            "#66bb6a", "#ffa726", "#8d6e63",
            "#bdbdbd", "#ffee58", "#42a5f5",
            "#26a69a", "#ec407a", "#78909c",
            "#827717", "#8D6E63", "#607D8B",
            "#ff1744", "#00C853", "#FFFF00"
        ];
        return array.sort(() => Math.random() - Math.random()).slice(0, num);
    };

    let printPageBtnHandler = function () {
        $("#print-page").click(function () {
            window.print();
        });
    }

    $(document).ready(function () {
        init();
    });

})();
