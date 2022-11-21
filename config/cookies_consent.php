<?php

return [
    /**
     * This prefix will be applied when setting and getting all cookies.
     * If not set, the cookies will not be prefixed.
     * If set, a good strategy is to also add a trailing underscore "_", that will be added between the field value, and each cookie.
     * For example, if `cookie_prefix` is set to `my_app_`, then the targeting cookie will have a value of `my_app_cookies_consent_targeting`.
     * When using this plugin for multiple apps, it is a good strategy to set a prefix that is relevant to the app
     * (for example "my_app_", in order for the cookies not to be mingled when running locally.
     */
    'cookie_prefix' => 'crowdsourcing_app_',
    /*
    |--------------------------------------------------------------------------
    | Editor
    |--------------------------------------------------------------------------
    |
    | Choose your preferred cookies to be shown. You can add more cookies as desired.
    | If, for example you add another cookie with the name "marketing", then you should also
    | publish the translation files and add a "cookie_marketing" key in the translation file,
    | since the plugin will try to display the cookie name by this convention.
    |
    | Built-in: "strictly_necessary", "performance", "targeting", "functionality"
    |
    */
    'cookies' => [
        'strictly_necessary',
        'targeting'
    ],
    'enabled' => [
        'strictly_necessary',
        'targeting'
    ],
    'required' => ['strictly_necessary'],
    /*
     * Set the cookie duration in days.  Default is 365 * 10.
     */
    'cookie_lifetime' => 365 * 10,
];
