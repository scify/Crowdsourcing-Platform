import "jquery-toast-plugin";

export function arrayMove(arr, fromIndex, toIndex) {
	const element = arr[fromIndex];
	arr.splice(fromIndex, 1);
	arr.splice(toIndex, 0, element);
}

export function showToast(
	text,
	bgColor,
	position = "top-right",
	hideAfter = 4000,
	icon = null,
	allowToastClose = true,
) {
	const options = {
		text: text,
		showHideTransition: "slide", // It can be plain, fade or slide
		bgColor: bgColor, // Background color for toast
		textColor: "#eee", // text color
		allowToastClose: allowToastClose, // Show the close button or not
		hideAfter: hideAfter, // `false` to make it sticky or time in miliseconds to hide after
		stack: 5, // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
		textAlign: "left", // Alignment of text i.e. left, right, center
		position: position, // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object
		// representing the left, right, top, bottom values to position the toast on page
	};

	if (icon) options.icon = icon;

	$.toast(options);
}

export function setCookie(cname, cvalue, exdays) {
	const d = new Date();
	d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
	const expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

export function getCookie(cname) {
	const name = cname + "=";
	const decodedCookie = decodeURIComponent(document.cookie);
	const ca = decodedCookie.split(";");
	for (let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while (c.charAt(0) === " ") {
			c = c.substring(1);
		}
		if (c.indexOf(name) === 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
