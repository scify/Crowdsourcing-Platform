const COLLAPSED_KEY = "backoffice.sidebar-collapsed";

// Backoffice pages mount Vue apps onto #app, and Vue 3 replaces the container's
// DOM. A listener bound directly to #sidebar-menu-toggler is therefore lost when
// the element is re-created. Delegate from the document instead, which survives
// any re-render of the subtree.
//
// The guard lives on window, not in module scope. Under Vite dev and HMR this
// module can be instantiated more than once under different URLs (`?t=` stamped
// versus unstamped after an invalidation). A module-level flag is per-instance,
// so each instance would bind its own listener and a single click would toggle
// the class on and straight back off.

export function initBackofficeSidebar() {
	try {
		if (localStorage.getItem(COLLAPSED_KEY) === "1") {
			document.body.classList.add("sidebar-collapsed");
		}
	} catch {
		// localStorage unavailable (private mode); ignore
	}

	if (window.__backofficeSidebarBound) {
		return;
	}
	window.__backofficeSidebarBound = true;

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
