import AnalyticsLogger from "../analytics-logger";

(function () {
	const socialShareHandler = function () {
		$("body").on("click", ".social-share-button", function () {
			setTimeout(function () {
				$(".share-success").removeClass("d-none");
			}, 2000);
			const project = $(this).data("project");
			const questionnaire = $(this).data("questionnaire");
			const questionnaireId = $(this).data("questionnaireid");
			const medium = $(this).data("medium");
			const url = $(this).attr("href");
			AnalyticsLogger.logEvent(
				"user_engagement",
				"questionnaire_share_" + questionnaire,
				"share",
				JSON.stringify({
					questionnaire: questionnaire,
					project: project,
					medium: medium,
					url: url,
				}),
				questionnaireId,
			);
		});
	};

	const init = function () {
		socialShareHandler();
	};

	init();
})();
