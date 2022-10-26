class AnalyticsLogger {

	static logEvent(category, action, label, value) {
		if (this.isGoogleAnalyticsLoaded()) {
			window.ga("send", {
				hitType: "event",
				eventCategory: category,
				eventAction: action,
				eventLabel: label,
				eventValue: value
			});
		}
	}

	static isGoogleAnalyticsLoaded() {
		return typeof ga === "function";
	}

}

export default AnalyticsLogger;
