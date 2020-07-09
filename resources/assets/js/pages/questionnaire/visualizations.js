'use strict';
import Chart from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

(function () {
    let init = function () {
        initQuestionnaireResponsesChart();
        initQuestionnaireResponsesPerLanguageChart();
        initQuestionResponsesCharts();
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

        const options = {
            tooltips: {
                enabled: true
            },
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

        const responsesChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });
    };

    let initQuestionnaireResponsesPerLanguageChart = function () {
        let ctx = document.getElementById('responsesPerLanguageChart').getContext("2d");

        const data = {
            datasets: [{
                data: _.map(viewModel.numberOfResponsesPerLanguage.data, 'num_responses'),
                backgroundColor: getRandomColors(viewModel.numberOfResponsesPerLanguage.data.length)
            }],

            labels: _.map(viewModel.numberOfResponsesPerLanguage.data, 'language_name')
        };

        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: getChartOptions('bar')
        });
    };

    let initQuestionResponsesCharts = function () {
        for (let i = 0; i < viewModel.statisticsPerQuestion.length; i++) {
            const questionStatisticsObj = viewModel.statisticsPerQuestion[i];
            let canvasElement = $('.questionResponsesChart[data-question-id=' +
                questionStatisticsObj.question_id + ']')[0];

            createChartForQuestionStatistics(canvasElement, questionStatisticsObj);
        }
    };

    let createChartForQuestionStatistics = function(canvasElement, questionStatisticsObj) {
        switch (questionStatisticsObj.question_type) {
            case 'fixed_choices':
                createChartForFixedChoiceQuestionStatistics(canvasElement, questionStatisticsObj.statistics);
                break;
            case 'free_text':
                createChartForFreeTextQuestionStatistics(canvasElement, questionStatisticsObj.statistics);
                break;
        }
    };

    let createChartForFixedChoiceQuestionStatistics = function(canvasElement, questionStatistics) {
        let ctx = canvasElement.getContext("2d");
        const data = {
            datasets: [{
                data: _.map(questionStatistics, 'num_responses'),
                backgroundColor: getRandomColors(questionStatistics.length)
            }],

            labels: _.map(questionStatistics, 'answer_title')
        };

        const responsesChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: data,
            options: getChartOptions('horizontalBar')
        });
    };

    let createChartForFreeTextQuestionStatistics = function(canvasElement, questionStatistics) {
        console.log(questionStatistics);
    };

    let getChartOptions = function (chartType) {
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
            "#26a69a", "#ec407a", "#78909c"
        ];
        return array.sort(() => Math.random() - Math.random()).slice(0, num);
    };

    $(document).ready(function () {
        init();
    });

})();
