<?php

namespace App\Utils;

use Exception;
use Spatie\Newsletter\Facades\Newsletter;

class MailChimpAdaptor {
    /**
     * @throws Exception
     */
    public function subscribe($email, $listName, $name): void {
        if (config('app.mailchimp_api_key') && config('app.mailchimp_api_key') != '') {
            $mergeFields = [];
            if ($name) {
                $mergeFields['FNAME'] = $name;
            }
            if (!Newsletter::isSubscribed($email, $listName)) {
                Newsletter::subscribeOrUpdate($email, $mergeFields, $listName);
            }
        }
    }
}
