import "admin-lte/plugins/datatables/jquery.dataTables.min";

window.UsersListController = function () {
};

window.UsersListController.prototype = function () {
	let usersCriteria = {},
		pageNum = 1;
	let searchBtnHandler = function () {
		$("#searchBtn").on("click", function () {
			getUsersByFilters.call(this);
		});
	};
	let paginateUsersBtnHandler = function () {
		$("body").on("click", "#usersList .pagination a", function (e) {
			e.preventDefault();

			if (!$(this).parent().hasClass("active")) {
				let pageParam = $(this).attr("href").split("?page=")[1];
				pageNum = pageParam ? pageParam : 1;
				$("#usersFilters").find("#searchBtn").trigger("click");
			}
		});
	};
	let getUsersByFilters = function () {
		// button pressed that triggered this function
		let self = this;
		usersCriteria.page = pageNum;
		usersCriteria.email = $("input[name=filter_email]").val();
		$.ajax({
			method: "GET",
			url: $(".filtersContainer").data("url"),
			cache: false,
			data: usersCriteria,
			beforeSend: function () {
				$(self).parents(".panel-body").first().append("<div class=\"refresh-container\"><div class=\"loading-bar indeterminate\"></div></div>");
				$("#users-list-loader").removeClass("hidden");
			},
			success: function (response) {
				$(".refresh-container").fadeOut(500, function () {
					$(".refresh-container").remove();
				});
				parseSuccessData(response);
				$("#users-list-loader").addClass("hidden");
			},
			error: function (xhr, status, errorThrown) {
				const errorMsgEl = $("#errorMsg");
				$(".refresh-container").fadeOut(500, function () {
					$(".refresh-container").remove();
				});
				errorMsgEl.removeClass("hidden");
				//The message added to Response object in Controller can be retrieved as following.
				errorMsgEl.html(errorThrown);
				$("#users-list-loader").addClass("hidden");
			}
		});
	};
	let parseSuccessData = function (response) {
		const errorMsgEl = $("#errorMsg");
		const usersListEl = $("#usersList");
		const loaderEl = $("#users-list-loader");
		let responseObj = JSON.parse(response);
		//if operation was unsuccessful
		if (responseObj.status === 2) {
			loaderEl.addClass("hidden");
			errorMsgEl.removeClass("hidden");
			errorMsgEl.html(responseObj.data);
			usersListEl.html("");
		} else {
			errorMsgEl.html("");
			errorMsgEl.addClass("hidden");
			loaderEl.addClass("hidden");
			usersListEl.html(responseObj.data);
		}
	};
	let initDataTables = function () {
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
	};
	let init = function () {
		$(document).ready(function () {
			searchBtnHandler();
			paginateUsersBtnHandler();
			initDataTables();
		});
	};
	return {
		init: init
	};
}();
