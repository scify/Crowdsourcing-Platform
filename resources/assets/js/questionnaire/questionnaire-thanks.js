(function () {
	let init = function () {
		$("#pyro").addClass("pyro-on");
		const anonymousResponseModal = window.$(".anonymous-response");
		if (anonymousResponseModal.length) {
			anonymousResponseModal.modal({ backdrop: "static" });
			window.setTimeout(function () {
				//dirty fix. For some reason the class modal-open is missing from the body in some cases at chrome
				$("body").addClass("modal-open");
			}, 500);
		}
	};
	$(document).ready(function () {
		init();
	});
})();
