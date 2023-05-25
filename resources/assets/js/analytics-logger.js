class AnalyticsLogger {

	static logEvent(eventType, category, action, label, value) {
		if (this.isGoogleAnalyticsLoaded()) {
			window.gtag("event", eventType, {
				eventCategory: category,
				eventAction: action,
				eventLabel: label,
				eventValue: value
			});
		}
	}

	static isGoogleAnalyticsLoaded() {
		return window.gtag !== undefined;
	}

}

export default AnalyticsLogger;
