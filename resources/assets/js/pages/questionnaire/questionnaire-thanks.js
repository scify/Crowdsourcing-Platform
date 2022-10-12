(function () {

	let init = function () {
		$("#pyro").addClass("pyro-on");
		const anonymousResponseModal = $(".anonymous-response");
		if (anonymousResponseModal.length) {
			anonymousResponseModal.modal({backdrop: "static"});
			window.setTimeout(function () {
				//dirty fix. For some reason the class modal-open is missing from the body in some cases at chrome
				$("body").addClass("modal-open");
			}, 500);
		}
		// remove the anonymous user id from the URL
		//window.history.pushState({}, document.title, window.location.pathname);
	};
	$(document).ready(function () {
		init();
	});

})();