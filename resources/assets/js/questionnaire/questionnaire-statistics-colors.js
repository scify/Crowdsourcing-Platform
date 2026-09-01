import "jquery/dist/jquery.min";
import Coloris from "@melloware/coloris";

(function () {
	const init = function () {
		initializeColorPicker();
	};

	const initializeColorPicker = function () {
		Coloris.init();
		Coloris({
			el: ".color-picker-input",
			format: "hex",
		});
	};

	$(document).ready(function () {
		init();
	});
})();
