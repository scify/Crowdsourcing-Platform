const COLLAPSED_KEY = "backoffice.sidebar-collapsed";

export function initBackofficeSidebar() {
	const body = document.body;

	try {
		if (localStorage.getItem(COLLAPSED_KEY) === "1") {
			body.classList.add("sidebar-collapsed");
		}
	} catch {
		// localStorage unavailable (private mode); ignore
	}

	const toggler = document.getElementById("sidebar-menu-toggler");
	if (!toggler) {
		return;
	}

	toggler.addEventListener("click", (e) => {
		e.preventDefault();
		const collapsed = body.classList.toggle("sidebar-collapsed");
		try {
			localStorage.setItem(COLLAPSED_KEY, collapsed ? "1" : "0");
		} catch {
			// ignore
		}
	});
}
