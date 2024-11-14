import { createApp } from "vue";
import store from "../../store/store";

import TranslationsManager from "../../vue-components/common/TranslationsManager.vue";

import $ from "jquery";

const app = createApp({
	components: {
		TranslationsManager,
	},
});

app.use(store);
app.mount("#app");

(function () {

	const initializeImgFileChangePreviewHandlers = function () {
		$(".js-image-input").each(function (i, obj) {
			$(obj).change(function () {
				const event = this;
				if (event.files && event.files[0]) {
					const parent = $(obj).closest(".js-image-input-container");
					const imgPreview = parent.find(".js-selected-image-preview");
					const reader = new FileReader();
					reader.onload = function (e) {
						imgPreview.attr("src", e.target.result);
					};
					reader.readAsDataURL(event.files[0]);
				}
			});
		});
	};

    const checkURLAndActivateTranslationsTab = function () {
        // should check the URL for a `translations=1` variable and if set and if true, it should activate the tab. SEE DESCR
        if ( (window.location.search.indexOf("?translations=1") > -1) || (window.location.search.indexOf("&translations=1") > -1)) {
            $("#translations-tab").click();
        }
    };

	const init = function () {
		initializeImgFileChangePreviewHandlers();
        checkURLAndActivateTranslationsTab();
	};

	$(document).ready(function () {
		init();
	});

})();
