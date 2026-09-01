const COLLAPSED_KEY = "backoffice.sidebar-collapsed";

// Backoffice pages mount Vue apps onto #app, and Vue 3 replaces the container's
// DOM. A listener bound directly to #sidebar-menu-toggler is therefore lost when
// the element is re-created. Delegate from the document instead, which survives
// any re-render of the subtree.
let bound = false;

export function initBackofficeSidebar() {
	try {
		if (localStorage.getItem(COLLAPSED_KEY) === "1") {
			document.body.classList.add("sidebar-collapsed");
		}
	} catch {
		// localStorage unavailable (private mode); ignore
	}

	if (bound) {
		return;
	}
	bound = true;

	document.addEventListener("click", (e) => {
		const toggler = e.target.closest("#sidebar-menu-toggler");
		if (!toggler) {
			return;
		}

		e.preventDefault();
		const collapsed = document.body.classList.toggle("sidebar-collapsed");
		try {
			localStorage.setItem(COLLAPSED_KEY, collapsed ? "1" : "0");
		} catch {
			// ignore
		}
	});
}
