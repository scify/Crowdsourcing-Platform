'use strict';
import Chart from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

(function () {
    let init = function () {
        initQuestionnaireResponsesChart();
        initQuestionnaireResponsesPerLanguageChart();
    };

    let initQuestionnaireResponsesChart = function () {
        let ctx = document.getElementById('responsesChart').getContext("2d");

        const data = {
            datasets: [{
                data: [150, 78],
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
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        const percentage = (value*100 / sum).toFixed(2)+"%";
                        return value + ' responses\n' + percentage;
                    },
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
                data: [24, 45, 12, 4, 32, 9, 18],
                backgroundColor: getRandomColors(7)
            }],

            labels: [
                'English',
                'Greek',
                'Italian',
                'Albanian',
                'Spanish',
                'French',
                'Portuguese'
            ]
        };

        const options = {
            legend: { display: false },
            tooltips: {
                enabled: true
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        const percentage = (value*100 / sum).toFixed(2)+"%";
                        return value + ' responses\n' + percentage;
                    },
                    color: '#222',
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

        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    };

    let getRandomColors = function(num) {
        const array = [
            "#ef5350", "#ab47bc","#5c6bc0",
            "#66bb6a","#ffa726", "#8d6e63",
            "#bdbdbd", "#ffee58", "#42a5f5",
            "#26a69a", "#ec407a", "#78909c"
        ];
        return array.sort(() => Math.random() - Math.random()).slice(0, num);
    };

    $(document).ready(function () {
        init();
    });

})();
