<?php

return [
    /**
     * This prefix will be applied when setting and getting all cookies.
     * If not set, the cookies will not be prefixed.
     * If set, a good strategy is to also add a trailing underscore "_", that will be added between the field value, and each cookie.
     * For example, if `cookie_prefix` is set to `my_app_`, then the cookies will be stored in a JSON object with the key `my_app_cookies_consent_selection`.
     * Example:
     *
     * {
     *    "my_app_cookies_consent_selection": {
     *       "strictly_necessary": true,
     *      "performance": false,
     *     "targeting": false
     *   }
     * }
     */
    'cookie_prefix' => 'crowdsourcing_app_',
    'display_floating_button' => true, // Set to false to display the footer link instead
    'use_separate_page' => false, // Set to true to use a separate page for cookies explanation
    /*
    |--------------------------------------------------------------------------
    | Editor
    |--------------------------------------------------------------------------
    |
    | Choose your preferred cookies to be shown. You can add more cookies as desired.
    |
    */
    'cookies' => [
        'strictly_necessary' => [
            [
                'name' => 'cookieConsent',
                'description' => 'This cookie is set by the GDPR Cookie Consent plugin and is used to store whether or not user has consented to the use of cookies. It does not store any personal data.',
                'duration' => '2 years',
                'policy_external_link' => null,
            ],
            [
                'name' => 'XSRF-TOKEN',
                'description' => 'This cookie is set by Laravel to prevent Cross-Site Request Forgery (CSRF) attacks.',
                'duration' => '2 hours',
                'policy_external_link' => null,
            ],
            [
                'name' => 'lets_crowdsource_our_future_session',
                'description' => 'This cookie is set by Laravel to identify a session instance for the user.',
                'duration' => '2 hours',
                'policy_external_link' => null,
            ],
        ],
        'targeting' => [
            [
                'name' => '_ga',
                'description' => 'This cookie is installed by Google Analytics. The cookie is used to calculate visitor, session, campaign data and keep track of site usage for the site\'s analytics report. The cookies store information anonymously and assign a randomly generated number to identify unique visitors.',
                'duration' => '2 years',
                'policy_external_link' => 'https://policies.google.com/privacy?hl=en-US',
            ],
            [
                'name' => '_gid',
                'description' => 'This cookie is installed by Google Analytics. The cookie is used to store information of how visitors use a website and helps in creating an analytics report of how the website is doing. The data collected including the number visitors, the source where they have come from, and the pages visited in an anonymous form.',
                'duration' => '1 day',
                'policy_external_link' => 'https://policies.google.com/privacy?hl=en-US',
            ],
            [
                'name' => '_gat',
                'description' => 'This cookies is installed by Google Universal Analytics to throttle the request rate to limit the colllection of data on high traffic sites.',
                'duration' => '1 minute',
                'policy_external_link' => 'https://policies.google.com/privacy?hl=en-US',
            ],
            [
                'name' => 'bcookie',
                'description' => 'This cookie is set by LinkedIn. The purpose of the cookie is to enable LinkedIn functionalities on the page.',
                'duration' => '2 years',
                'policy_external_link' => 'https://www.linkedin.com/legal/privacy-policy',
            ],
            [
                'name' => '_fbp',
                'description' => 'This cookie is set by Facebook to deliver advertisement when they are on Facebook or a digital platform powered by Facebook advertising after visiting this website.',
                'duration' => '3 months',
                'policy_external_link' => 'https://www.facebook.com/policy/cookies/',
            ],
            [
                'name' => '_gcl_au',
                'description' => 'This cookie is used by Google Analytics to understand user interaction with the website.',
                'duration' => '2 months',
                'policy_external_link' => 'https://policies.google.com/privacy?hl=en-US',
            ],
            [
                'name' => 'guest_id',
                'description' => 'This cookie is set by Twitter. This cookie is used to identify and track the website visitor.',
                'duration' => '2 years',
                'policy_external_link' => 'https://twitter.com/en/privacy',
            ],
            [
                'name' => 'guest_id_ads',
                'description' => 'This cookie is set by Twitter. This cookie is used to identify and track the website visitor.',
                'duration' => '2 years',
                'policy_external_link' => 'https://twitter.com/en/privacy',
            ],
            [
                'name' => 'guest_id_marketing',
                'description' => 'This cookie is set by Twitter. This cookie is used to identify and track the website visitor.',
                'duration' => '2 years',
                'policy_external_link' => 'https://twitter.com/en/privacy',
            ],
            [
                'name' => 'li_gc',
                'description' => 'This cookie is set by LinkedIn. This cookie is used to store consent of guests regarding the use of cookies for non-essential purposes.',
                'duration' => '2 years',
                'policy_external_link' => 'https://www.linkedin.com/legal/privacy-policy',
            ],
            [
                'name' => 'lidc',
                'description' => 'This cookie is set by LinkedIn and used for routing.',
                'duration' => '1 day',
                'policy_external_link' => 'https://www.linkedin.com/legal/privacy-policy',
            ],
            [
                'name' => 'muc_ads',
                'description' => 'This cookie is set by Twitter. This cookie is used to identify and track the website visitor.',
                'duration' => '2 years',
                'policy_external_link' => 'https://twitter.com/en/privacy',
            ],
            [
                'name' => 'personalization_id',
                'description' => 'This cookie is set by Twitter. This cookie is used to identify and track the website visitor.',
                'duration' => '2 years',
                'policy_external_link' => 'https://twitter.com/en/privacy',
            ],
        ],
    ],
    'enabled' => [
        'strictly_necessary',
    ],
    'required' => ['strictly_necessary'],
    /*
     * Set the cookie duration in days.  Default is 365 days.
     */
    'cookie_lifetime' => 365,
];
