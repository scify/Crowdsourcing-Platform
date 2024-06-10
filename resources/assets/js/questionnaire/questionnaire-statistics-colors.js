import "jquery/dist/jquery.min";
import "bootstrap/dist/js/bootstrap.min";
import "bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min";

(function () {
	let init = function () {
		initializeColorPicker();
	};

	let initializeColorPicker = function () {
		$(".color-picker").each(function (i, el) {
			initSingleColorPicker(el);
		});
	};

	let initSingleColorPicker = function (el) {
		$(el).colorpicker({
			horizontal: true,
		});
		$(el).on("colorpickerCreate", function (event) {
			$(el).find(".input-group-addon").css("background-color", event.color.toString());
		});

		$(el).on("colorpickerChange", function (event) {
			$(el).find(".input-group-addon").css("background-color", event.color.toString());
		});
	};

	$(document).ready(function () {
		init();
	});
})();
