// import "select2";
// import "summernote/dist/summernote-bs4.min";

// import { createApp } from "vue";
// import store from "../store/store";

// import TranslationsManager from "../vue-components/common/TranslationsManager.vue";
// import CrowdSourcingProjectColors from "../vue-components/crowd-sourcing-project/CrowdSourcingProjectColors.vue";

// import select2 from "select2";
import $ from "jquery";

// select2($);

// const app = createApp({
// 	components: {
// 		TranslationsManager,
// 		CrowdSourcingProjectColors,
// 	},
// });

// app.use(store);
// app.mount("#app");

(function () {
	// const initializeSummernote = function () {
	// 	window.setTimeout(function () {
	// 		$(".summernote").summernote({
	// 			height: 150, // set editable area's height
	// 			prettifyHtml: true,
	// 		});
	// 		initializeCommunicationResourcesHandlers();
	// 	}, 2000);
	// };

	// const initializeSubmitFormListener = function () {
	// 	$("#project-form").one("submit", function (event) {
	// 		event.preventDefault();
	// 		fixAllSummerNoteCodes();
	// 		$(this).submit();
	// 	});
	// };

	// const fixAllSummerNoteCodes = function () {
	// 	$(".summernote").each((index, element) => {
	// 		updateSummerNoteCodeContent($(element));
	// 	});
	// };

	// const updateSummerNoteCodeContent = function (el) {
	// 	el.val(el.summernote("code"));
	// };

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

	// const initializeCommunicationResourcesHandlers = function () {
	// 	initializeSummernoteAndUpdateElementOnKeyup($("#questionnaire_response_email_intro_text"), $("#intro_text"));
	// 	initializeSummernoteAndUpdateElementOnKeyup($("#questionnaire_response_email_outro_text"), $("#outro_text"));
	// };

	// const initializeSummernoteAndUpdateElementOnKeyup = function (summernoteEl, targetEl) {
	// 	summernoteEl.summernote({
	// 		height: 150,
	// 		callbacks: {
	// 			onChange: function (contents) {
	// 				setTimeout(function () {
	// 					targetEl.html(contents);
	// 				}, 50);
	// 			},
	// 		},
	// 	});
	// };

	// const initializeSocialMediaKeywordsTags = function () {
	// 	$("#social-media-tab").one("click", function () {
	// 		window.setTimeout(function () {
	// 			$("#sm_keywords").select2({
	// 				tags: true,
	// 			});
	// 		}, 200);
	// 	});
	// };

    const checkURLAndActivateTranslationsTab = function () {
        // should check the URL for a `translations=1` variable and if set and if true, it should activate the tab. SEE DESCR
        if ( (window.location.search.indexOf("?translations=1") > -1) || (window.location.search.indexOf("&translations=1") > -1)) {
            $("#translations-tab").click();
        }
    };

	const init = function () {
		// initializeSubmitFormListener();
		initializeImgFileChangePreviewHandlers();
		// initializeSummernote();
		// initializeSocialMediaKeywordsTags();
        checkURLAndActivateTranslationsTab();
	};

	$(document).ready(function () {
		init();
	});

})();
