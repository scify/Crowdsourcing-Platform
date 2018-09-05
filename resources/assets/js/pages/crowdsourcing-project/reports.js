require('datatables.net-bs');
require('datatables.net-buttons');

(function () {

    let initializeDataTable = function () {
        var container = $("#table1");

        container.DataTable({

            destroy: true,
            "paging": true,
            "searching": true,
            "info": false,
            dom: 'Bfrtip',
            buttons: [
              'excelHtml5',
                'csvHtml5'
            ]
        });
    };

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
                $('.box-body').first().append('<div class="refresh-container"><div class="loading-bar indeterminate"></div></div>');
            },
            success: function (response) {
                parseSuccessData(response);
                $('.refresh-container').fadeOut(500, function() {
                    $('.refresh-container').remove();
                });
            },
            error: function (xhr, status, errorThrown) {
                $('.refresh-container').fadeOut(500, function() {
                    $('.refresh-container').remove();
                });
                console.log(xhr.responseText);
                $("#errorMsg").removeClass('hidden');
                //The message added to Response object in Controller can be retrieved as following.
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
        }
    };

    let init = function () {
        initializeDataTable();
    };

    $(document).ready(function() {
        init();
        searchBtnHandler();
    });
})();