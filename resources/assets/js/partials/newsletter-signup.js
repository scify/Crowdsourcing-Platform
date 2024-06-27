(function () {
	const signUpForNewsletter = function () {
		const wrapper = $(".sign-up");
		const url = wrapper.data("url");
		const first_name = wrapper.find("[name='first_name']").val();
		const email = wrapper.find("[name='email']").val();
		$.ajax({
			method: "post",
			url: url,
			data: { first_name, email },
			beforeSend: function () {
				$(".loader-wrapper").removeClass("hidden");
			},
			success: function () {
				$(".newsletter-msg").addClass("success");
				$(".signup-btn").remove();
				wrapper
					.find(".col-md-2")
					.last()
					.append(
						"<div class='btn btn-block btn-success'><span class='fa fa-check-circle'></span> Subscribed!</div>",
					);
				wrapper.find("input").attr("disabled", "disabled");
			},
			error: function () {
				$(".newsletter-msg").addClass("error");
			},
			complete: function () {
				$(".loader-wrapper").addClass("hidden");
			},
		});
	};

	const initEvents = function () {
		$(".signup-btn").click(signUpForNewsletter);
	};

	const init = function () {
		initEvents();
	};

	init();
})();
