window.UsersListController = function () {
};

window.UsersListController.prototype = function () {
    var usersCriteria = {},
        searchBtnHandler = function () {
            $("#searchBtn").on("click", function () {
                getUsersByFilters.call(this);
            });
        },
        paginateUsersBtnHandler = function () {
            $("body").on("click", "#usersList .pagination a", function (e) {
                e.preventDefault();

                if (!$(this).parent().hasClass("active")) {
                    $("#usersFilters").find("#searchBtn").trigger("click");
                }
            });
        },
        getUsersByFilters = function () {
            // button pressed that triggered this function
            let self = this;
            let pageParam = $(this).attr("href").split('#?page=')[1];
            console.log(pageParam);
            usersCriteria.page = pageParam ? pageParam : 1;
            usersCriteria.email = $('input[name=filter_email]').val();
            $.ajax({
                method: "GET",
                url: $(".filtersContainer").data("url"),
                cache: false,
                data: usersCriteria,
                beforeSend: function () {
                    $(self).parents('.panel-body').first().append('<div class="refresh-container"><div class="loading-bar indeterminate"></div></div>');
                    $("#usersBottomLoader").removeClass("invisible");
                },
                success: function (response) {
                    $('.refresh-container').fadeOut(500, function () {
                        $('.refresh-container').remove();
                    });
                    parseSuccessData(response);
                    $("#mentorsBottomLoader").addClass("invisible");
                },
                error: function (xhr, status, errorThrown) {
                    $('.refresh-container').fadeOut(500, function () {
                        $('.refresh-container').remove();
                    });
                    console.log(xhr.responseText);
                    $("#errorMsg").removeClass('hidden');
                    //The message added to Response object in Controller can be retrieved as following.
                    $("#errorMsg").html(errorThrown);
                    $("#mentorsBottomLoader").addClass("invisible");
                }
            });
        },
        parseSuccessData = function (response) {
            let responseObj = JSON.parse(response);
            //if operation was unsuccessful
            if (responseObj.status === 2) {
                $(".loader").addClass('hidden');
                $("#errorMsg").removeClass('hidden');
                $("#errorMsg").html(responseObj.data);
                $("#usersList").html("");
            } else {
                $("#usersList").html("");
                $("#errorMsg").addClass('hidden');
                $(".loader").addClass('hidden');
                $("#usersList").html(responseObj.data);
            }
        },
        initDataTables = function () {
            let table = $("#userListTable");

            table.DataTable({
                destroy: true,
                "paging": false,
                "responsive": true,
                "searching": false,
                "columns": [
                    {"width": "25%"},
                    {"width": "25%"},
                    {"width": "25%"},
                    {"width": "25%"}
                ]
            });
        },
        init = function (currentRouteName) {
            $(document).ready(function () {
                searchBtnHandler();
                paginateUsersBtnHandler();
                initDataTables();
            });

        };
    return {
        init: init
    }
}();
