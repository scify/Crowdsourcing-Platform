// jQuery 4 no longer exports ./dist/jquery.min; import the package entry
import $ from "jquery";
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
