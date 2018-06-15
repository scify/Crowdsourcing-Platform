window.UsersListController = function () {
};

window.UsersListController.prototype = function () {
    var usersCriteria = {},
        pageNum = 1,
        searchBtnHandler = function () {
            $("#searchBtn").on("click", function () {
                getUsersByFilters.call(this);
            });
        },
        getUsersByFilters = function () {
            // button pressed that triggered this function
            var self = this;
            usersCriteria.page = pageNum;
            usersCriteria.email = $('input[name=email]').val();
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
                    $('.refresh-container').fadeOut(500, function() {
                        $('.refresh-container').remove();
                    });
                    parseSuccessData(response);
                    $("#mentorsBottomLoader").addClass("invisible");
                },
                error: function (xhr, status, errorThrown) {
                    $('.refresh-container').fadeOut(500, function() {
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
        parseSuccessData = function(response) {
            var responseObj = JSON.parse(response);
            //if operation was unsuccessful
            if (responseObj.status == 2) {
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
        init = function (currentRouteName) {
            searchBtnHandler();
        };
        return {
            init: init
        }
}();