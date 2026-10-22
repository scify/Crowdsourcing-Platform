(function () {
	const init = function () {
		$("#pyro").addClass("pyro-on");
		const anonymousResponseModalEl = document.querySelector(".anonymous-response");
		if (anonymousResponseModalEl) {
			window.bootstrap.Modal.getOrCreateInstance(anonymousResponseModalEl, { backdrop: "static" }).show();
			window.setTimeout(function () {
				// dirty fix. For some reason the class modal-open is missing from the body in some cases at chrome
				$("body").addClass("modal-open");
			}, 500);
		}
	};
	$(document).ready(function () {
		init();
	});
})();
