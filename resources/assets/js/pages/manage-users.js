import "datatables.net-buttons-bs4";
import "datatables.net-buttons/js/buttons.html5.mjs";

window.UsersListController = function () {};

window.UsersListController.prototype = (function () {
	const usersCriteria = {};
	let pageNum = 1;
	const searchBtnHandler = function () {
		$("#searchBtn").on("click", function () {
			getUsersByFilters.call(this);
		});
	};
	const paginateUsersBtnHandler = function () {
		$("body").on("click", "#usersList .pagination a", function (e) {
			e.preventDefault();

			if (!$(this).parent().hasClass("active")) {
				const pageParam = $(this).attr("href").split("?page=")[1];
				pageNum = pageParam ? pageParam : 1;
				$("#usersFilters").find("#searchBtn").trigger("click");
			}
		});
	};
	const getUsersByFilters = function () {
		// button pressed that triggered this function
		const self = this;
		usersCriteria.page = pageNum;
		usersCriteria.email = $("input[name=filter_email]").val();
		$.ajax({
			method: "GET",
			url: $(".filtersContainer").data("url"),
			cache: false,
			data: usersCriteria,
			beforeSend: function () {
				$(self)
					.parents(".panel-body")
					.first()
					.append('<div class="refresh-container"><div class="loading-bar indeterminate"></div></div>');
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
				// The message added to Response object in Controller can be retrieved as following.
				errorMsgEl.html(errorThrown);
				$("#users-list-loader").addClass("hidden");
			},
		});
	};
	const parseSuccessData = function (response) {
		const errorMsgEl = $("#errorMsg");
		const usersListEl = $("#usersList");
		const loaderEl = $("#users-list-loader");
		const responseObj = JSON.parse(response);
		// if operation was unsuccessful
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
	const initDataTables = function () {
		const table = $("#userListTable");

		table.DataTable({
			destroy: true,
			paging: false,
			searching: false,
			columns: [{ width: "25%" }, { width: "25%" }, { width: "25%" }, { width: "25%" }],
			layout: {
				topEnd: {
					buttons: [
						{
							extend: "csv",
							text: "CSV",
							title: "Users_" + new Date().getTime(),
							exportOptions: {
								modifier: {
									search: "none",
								},
							},
						},
					],
				},
			},
		});
	};
	const init = function () {
		$(document).ready(function () {
			searchBtnHandler();
			paginateUsersBtnHandler();
			initDataTables();
		});
	};
	return {
		init: init,
	};
})();

const usersListController = new window.UsersListController();
usersListController.init();
