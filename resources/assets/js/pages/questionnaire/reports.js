require('datatables.net-bs');
require('datatables.net-buttons');

(function () {

    let searchBtnHandler = function () {
        $("#searchBtn").on("click", function () {
            let criteria = {};
            criteria.projectId = $('select[name=project_id]').val();
            criteria.questionnaireId = $('select[name=questionnaire_id]').val();
            console.log(criteria);
            getReportsForCriteria(criteria);
        });
    };

    let getReportsForCriteria = function(criteria) {
        $.ajax({
            method: "GET",
            url: $("#searchBtn").data("url"),
            cache: false,
            data: criteria,
            beforeSend: function () {
                $(".loader-container").removeClass('hidden');
                $("#errorMsg").addClass('hidden');
            },
            success: function (response) {
                parseSuccessData(response);
                $(".loader-container").addClass('hidden');
            },
            error: function (xhr, status, errorThrown) {
                $(".loader-container").addClass('hidden');
                $("#errorMsg").removeClass('hidden');
                $("#errorMsg").html(errorThrown);
            }
        });
    };

    let parseSuccessData = function(data) {
        let responseObj = JSON.parse(data);
        //if operation was unsuccessful
        if (responseObj.status === 2) {
            $(".loader").addClass('hidden');
            $("#errorMsg").removeClass('hidden');
            $("#errorMsg").html(responseObj.data);
            $("#results").html("");
        } else {
            $("#results").html("");
            $("#errorMsg").addClass('hidden');
            $(".loader").addClass('hidden');
            $("#results").html(responseObj.data);
            initializeDataTable();
        }
    };

    let initializeDataTable = function () {
        let table = $("#resultsTable");
        console.log("here");
        table.DataTable({
            "paging": true,
            "searching": true,
            "pageLength": 15,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columns": [
                { "width": "10%" },
                { "width": "10%" },
                { "width": "50%" },
                { "width": "30%" }
            ]
        });
    };

    let init = function () {
        searchBtnHandler();
    };

    $(document).ready(function() {
        init();
    });
})();