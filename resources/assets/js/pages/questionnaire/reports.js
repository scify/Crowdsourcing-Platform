(function () {

    let table;
    const loader = $("#loader");

    let searchBtnHandler = function () {
        $("#searchBtn").on("click", function () {
            let criteria = {};
            criteria.questionnaireId = $('select[name=questionnaire_id]').val();
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
            error: function (xhr, status, errorThrown) {
                loader.addClass('d-none');
                $("#errorMsg").removeClass('d-none');
                console.log(errorThrown);
                $("#errorMsg").html("An error occurred");
            }
        });
    };

    let parseSuccessData = function (data) {
        let responseObj = JSON.parse(data);
        //if operation was unsuccessful
        if (responseObj.status === 2) {
            loader.addClass('d-none');
            $("#errorMsg").removeClass('d-none');
            $("#errorMsg").html(responseObj.data);
            $("#results").html("");
        } else {
            $("#results").html("");
            $("#errorMsg").addClass('d-none');
            loader.addClass('d-none');
            $("#results").html(responseObj.data);
            initializeDataTables();
        }
    };

    let initializeDataTables = function () {

        let respondentsTable = $("#respondentsTable");
        respondentsTable.DataTable({
            "paging": true,
            "searching": true,
            "responsive": true,
            "pageLength": 10,
            "columns" : [
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

        let answersTable = $("#answersTable");
        answersTable.DataTable({
            "paging": true,
            "searching": true,
            "responsive": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'Download as CSV',
                    filename: 'Answers_Questionnaire_' + $('select[name=questionnaire_id]').val() + '_' + new Date().getTime(),
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5]
                    }
                }

            ],
            "columns": [
                {"width": "5%"},
                {"width": "40%"},
                {"width": "5%"},
                {"width": "5%"},
                {"width": "10%"},
                {"width": "30%"},
            ],
            "initComplete": function (settings, json) {
            }
        });
    };

    let init = function () {
        searchBtnHandler();
        answersBtnHandler();
        triggerSearch();
    };

    $(document).ready(function () {
        init();
    });
})();
