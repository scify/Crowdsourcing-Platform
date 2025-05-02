import "select2";
import "summernote/dist/summernote-bs4.min";

import { createApp } from "vue";
import store from "../store/store";

import TranslationsManager from "../vue-components/common/TranslationsManager.vue";
import CrowdSourcingProjectColors from "../vue-components/backoffice/management/crowd-sourcing-project/CrowdSourcingProjectColors.vue";

import select2 from "select2";
import $ from "jquery";

select2($);

const app = createApp({
	components: {
		TranslationsManager,
		CrowdSourcingProjectColors,
	},
});

app.use(store);
app.mount("#app");

(function () {
	const initializeSummernote = function () {
		window.setTimeout(function () {
			$(".summernote").summernote({
				height: 150, // set editable area's height
				prettifyHtml: true,
				callbacks: {
					onChange: function (contents) {
						setTimeout(function () {
							$(this).val(contents);
						}, 50);
					},
					onImageUpload: function (files) {
						for (let i = 0; i < files.length; i++) {
							uploadImage(files[i], $(this));
						}
					},
				},
			});
			initializeCommunicationResourcesHandlers();
		}, 2000);
	};

	const initializeSubmitFormListener = function () {
		$("#project-form").one("submit", function (event) {
			event.preventDefault();
			fixAllSummerNoteCodes();
			$(this).submit();
		});
	};

	const fixAllSummerNoteCodes = function () {
		$(".summernote").each((index, element) => {
			updateSummerNoteCodeContent($(element));
		});
	};

	const updateSummerNoteCodeContent = function (el) {
		el.val(el.summernote("code"));
	};

	const initializeImgFileChangePreviewHandlers = function () {
		$(".image-input").each(function (i, obj) {
			$(obj).change(function () {
				const event = this;
				if (event.files && event.files[0]) {
					const parent = $(obj).closest(".image-input-container");
					const imgPreview = parent.find(".selected-image-preview");
					const reader = new FileReader();
					reader.onload = function (e) {
						imgPreview.attr("src", e.target.result);
					};
					reader.readAsDataURL(event.files[0]);
				}
			});
		});
	};

	const initializeCommunicationResourcesHandlers = function () {
		initializeSummernoteAndUpdateElementOnKeyup($("#questionnaire_response_email_intro_text"), $("#intro_text"));
		initializeSummernoteAndUpdateElementOnKeyup($("#questionnaire_response_email_outro_text"), $("#outro_text"));
	};

	const initializeSummernoteAndUpdateElementOnKeyup = function (summernoteEl, targetEl) {
		summernoteEl.summernote({
			height: 150,
			callbacks: {
				onChange: function (contents) {
					setTimeout(function () {
						targetEl.html(contents);
					}, 50);
				},
				onImageUpload: function (files) {
					for (let i = 0; i < files.length; i++) {
						uploadImage(files[i], summernoteEl);
					}
				},
			},
		});
	};

	const uploadImage = function (file, summernoteEl) {
		const data = new FormData();
		data.append("files[]", file);

		// Add a temporary message above the Summernote editor
		const messageId = "upload-message-" + Date.now();
		summernoteEl.before(`<div id="${messageId}" class="upload-message">Uploading image, please wait...</div>`);

		$.ajax({
			url: "/api/files/upload",
			method: "POST",
			data: data,
			contentType: false,
			processData: false,
			success: function (response) {
				const uploadedFilePath = Object.values(response)[0]; // Get the first uploaded file URL
				console.log(uploadedFilePath);
				summernoteEl.summernote("insertImage", uploadedFilePath);
			},
			error: function (xhr) {
				if (xhr.responseJSON && xhr.responseJSON.errors) {
					const errors = xhr.responseJSON.errors;
					let errorMessage = "File upload failed:\n";
					for (const field in errors) {
						if (errors.hasOwnProperty(field)) errorMessage += `${field}: ${errors[field].join(", ")}\n`;
					}
					alert(errorMessage);
				} else {
					alert("An unexpected error occurred during file upload.");
				}
			},
			complete: function () {
				// Remove the temporary message
				$(`#${messageId}`).remove();
			},
		});
	};

	const initializeSocialMediaKeywordsTags = function () {
		$("#social-media-tab").one("click", function () {
			window.setTimeout(function () {
				$("#sm_keywords").select2({
					tags: true,
				});
			}, 200);
		});
	};

	const init = function () {
		initializeSubmitFormListener();
		initializeImgFileChangePreviewHandlers();
		initializeSummernote();
		initializeSocialMediaKeywordsTags();
	};
	$(document).ready(function () {
		init();
	});
})();
