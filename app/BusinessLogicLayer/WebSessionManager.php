<?php

namespace App\BusinessLogicLayer;


class WebSessionManager {

    const REFERRER_ID_ACTION = 'referrer-id';

    public function setReferrerId($referrerId) {
        $this->set(self::REFERRER_ID_ACTION, $referrerId);
    }

    public function getReferredId() {
        return $this->get(self::REFERRER_ID_ACTION);
    }

    private function set($key, $value) {
        session([$key => $value]);
    }

    private function get($key) {
        return session($key);
    }

}