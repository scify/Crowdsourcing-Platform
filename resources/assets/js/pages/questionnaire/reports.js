import * as Survey from "survey-knockout";
import { Tabulator } from 'survey-analytics/survey.analytics.tabulator.js';

(function () {

    let table;
    const loader = $("#loader");
    let questionnaire;

    let checkForURLSearchParams = function () {
        let searchParams = new URLSearchParams(window.location.search);
        const questionnaireId = searchParams.get('questionnaireId');
        if (questionnaireId)
            $('select[name=questionnaire_id]').val(questionnaireId);
    };

    let updateURLSearchParams = function (criteria) {
        let searchParams = new URLSearchParams(window.location.search);
        let newURL = '';
        if (searchParams.has('questionnaireId')) {
            newURL = location.href.replace("questionnaireId="+searchParams.get('questionnaireId'), "questionnaireId="+criteria.questionnaireId);
        } else {
            newURL = location.href += "?questionnaireId="+criteria.questionnaireId;
        }

        if (window.history.replaceState) {
            window.history.replaceState({}, null, newURL);
        }
    };


    let searchBtnHandler = function () {
        $("#searchBtn").on("click", function () {
            let criteria = {};
            criteria.questionnaireId = $('select[name=questionnaire_id]').val();
            if(criteria.questionnaireId)
                updateURLSearchParams(criteria);
            getReportsForCriteria(criteria);
        });
    };

    let triggerSearch = function () {
        $("#searchBtn").trigger("click");
    };

    let answersBtnHandler = function () {
        $('body').on('click', '.more-btn', function (e) {
            e.preventDefault();
            let question = $(this).data('question');
            let data = $(this).data('answers');
            data = prepareDataForAnswersTable(data);
            if (table)
                table.destroy();
            table = $('#answerTextsTable').DataTable({
                data: data,
                responsive: true,
                columns: [
                    {title: "Original answer", width: '45%'},
                    {title: "English automatic translation", width: '45%'},
                    {title: "Initial language detected", width: '10%'}
                ],
                order: [[1, "desc"]]
            });
            $("#questionTitle").html(question);
            $("#answersModal").modal();
        });
    };

    let prepareDataForAnswersTable = function (data) {
        let dataToShow = [];
        for (let i = 0; i < data.length; i++) {
            dataToShow.push([data[i].answer, data[i].english_translation, data[i].initial_language_detected]);
        }
        return dataToShow;
    };

    let getReportsForCriteria = function (criteria) {
        $.ajax({
            method: "GET",
            url: $("#searchBtn").data("url"),
            cache: false,
            data: criteria,
            beforeSend: function () {
                loader.removeClass('d-none');
                $("#errorMsg").addClass('d-none');
            },
            success: function (response) {
                parseSuccessData(response);
                loader.addClass('d-none');
            },
            error: function (error) {
                loader.addClass('d-none');
                $("#errorMsg").removeClass('d-none');
                $("#errorMsg").html(error.responseJSON.data);
            }
        });
    };

    let parseSuccessData = function (response) {
        $("#results").html("");
        $("#errorMsg").addClass('d-none');
        loader.addClass('d-none');
        $("#results").html(response.data.view);
        questionnaire = response.data.questionnaire;
        initializeDataTables();
        initializeQuestionnaireResponsesReport(response.data.responses);
    };

    let initializeDataTables = function () {

        let respondentsTable = $("#respondentsTable");
        respondentsTable.DataTable({
            "paging": true,
            "searching": true,
            "responsive": true,
            "pageLength": 10,
            "columns": [
                {"width": "50%"},
                {"width": "50%"}
            ]
        });

        let usersTable = $("#usersTable");
        usersTable.DataTable({
            "paging": true,
            "searching": true,
            "responsive": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'Download as CSV',
                    filename: 'Respondents_Questionnaire_' + $('select[name=questionnaire_id]').val() + '_' + new Date().getTime()
                }

            ],
            "columns": [
                {"width": "5%"},
                {"width": "5%"},
                {"width": "2%"},
                {"width": "35%"},
                {"width": "2%"},
                {"width": "23%"},
                {"width": "23%"},
                {"width": "2%"},
            ],
            "initComplete": function (settings, json) {
            }
        });
    };

    let initializeQuestionnaireResponsesReport = function (responsesData) {
        Survey.StylesManager.applyTheme("bootstrap");
        const survey = new Survey.Model(JSON.parse(questionnaire.questionnaire_json));
        let panelEl = document.getElementById("questionnaire-responses-report");
        const answers = _.map(_.map(responsesData, 'response_json'), JSON.parse);
        panelEl.innerHTML = "";
        Tabulator.haveCommercialLicense = true;
        const surveyAnalyticsTabulator = new Tabulator(survey, answers, {});
        surveyAnalyticsTabulator.render(panelEl);
    };

    let init = function () {
        checkForURLSearchParams();
        searchBtnHandler();
        answersBtnHandler();
        triggerSearch();
    };

    $(document).ready(function () {
        init();
    });
})();
