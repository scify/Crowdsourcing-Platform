function routeFunction() {
	if (window.Laravel) {
		const routes = window.Laravel.routes;
		const args = Array.prototype.slice.call(arguments);
		const name = args.shift();
		if (routes[name] === undefined) {
			console.error("Route not found ", name);
		} else {
			let baseUrl = window.Laravel.baseUrl;
			if (!baseUrl.endsWith("/")) baseUrl += "/";

			return (
				baseUrl +
				routes[name]
					.split("/")
					.map((s) => (s[0] === "{" ? args.shift() : s))
					.join("/")
			);
		}
	}
}

export default routeFunction;
