import AnalyticsLogger from "../analytics-logger";
import { showToast } from "../common-utils";

import { createApp } from "vue";
import store from "../store/store";
import QuestionnaireDisplay from "../vue-components/questionnaire/QuestionnaireDisplay/QuestionnaireDisplay.vue";

import DOMPurify from "dompurify";

const app = createApp({
	components: {
		QuestionnaireDisplay,
	},
});

// Register the "sane-html" directive globally
app.directive("sane-html", {
	updated(el, binding) {
		el.innerHTML = DOMPurify.sanitize(binding.value);
	},
	mounted(el, binding) {
		el.innerHTML = DOMPurify.sanitize(binding.value);
	},
});

app.use(store);
app.mount("#app");

(function () {
	const displayTranslation = function () {
		if ($(this).find("option:selected").data("machine-generated") === 1)
			$("#machine-translation-indicator").removeClass("hide");
		else $("#machine-translation-indicator").addClass("hide");
	};

	const refreshPageToTheQuestionnaireSection = function () {
		const split = window.location.toString().split("#");
		window.location = split[0] + "#questionnaire";
		window.location.reload();
	};

	const initEvents = function () {
		$("#questionnaire-lang-selector").on("change", displayTranslation);
		$("#questionnaire-responded").find(".refresh-page").on("click", refreshPageToTheQuestionnaireSection);
	};

	const openQuestionnaireIfNeeded = function () {
		const respondQuestionnaire = $("#project-motto").find(".respond-questionnaire");
		if (respondQuestionnaire.first().data("open-on-load") === 1) {
			window.$("#questionnaire-modal").modal("show");
		}
	};

	const logToAnalytics = function () {
		const projectEl = $("#project");
		if (projectEl.data("name"))
			AnalyticsLogger.logEvent(
				"page_view",
				"project_landing_page",
				"view_" + projectEl.data("name"),
				projectEl.data("name"),
				parseInt(projectEl.data("id")),
			);
	};

	const showProjectBannerIfEnabled = function () {
		if (viewModel.project.display_landing_page_banner) {
			const bannerTitle = viewModel.project.currentTranslation
				? viewModel.project.currentTranslation.banner_title
				: viewModel.project.default_translation.banner_title;

			const bannerText = viewModel.project.currentTranslation
				? viewModel.project.currentTranslation.banner_text
				: viewModel.project.default_translation.banner_text;
			if (bannerTitle || bannerText)
				showToast(
					'<div class="project-toast"><h3>' + bannerTitle + "</h3><br><br>" + bannerText + "</div>",
					"#2e6da4",
					"bottom-right",
					false,
					null,
					true,
				);
		}
	};

	const init = function () {
		initEvents();
		openQuestionnaireIfNeeded();
		logToAnalytics();
		showProjectBannerIfEnabled();
	};
	$(document).ready(function () {
		init();
	});
})();
