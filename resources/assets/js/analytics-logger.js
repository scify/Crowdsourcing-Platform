class AnalyticsLogger {

    static logEvent(category, action, label, value) {
        if (this.isGoogleAnalyticsLoaded())
            ga('send', {
                hitType: 'event',
                eventCategory: category,
                eventAction: action,
                eventLabel: label,
                eventValue: value
            });
        console.log('log', category + ' ' +action + ' ' + label + ' ' + value);
    }

    static isGoogleAnalyticsLoaded() {
        return typeof ga === 'function';
    }

}

export default AnalyticsLogger;
