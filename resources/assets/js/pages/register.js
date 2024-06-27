(function () {
	const initEvents = function () {
		const nicknameEl = $('input[name="nickname"]');
		nicknameEl.on("keyup", function () {
			if ($(this).val().length > 2) $("#nickname-help").removeClass("hidden");
		});
	};
	initEvents();
})();
