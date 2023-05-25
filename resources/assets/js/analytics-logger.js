class AnalyticsLogger {

    static logEvent(category, action, label, value) {
        if (this.isGoogleAnalyticsLoaded()) {
            console.log("gtag enabled");
            window.gtag("event", "screen_view", {
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
