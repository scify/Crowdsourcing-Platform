<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer;

class WebSessionManager {
    const REFERRER_ID_ACTION = 'referrer-id';

    public function setReferrerId($referrerId): void {
        $this->set(self::REFERRER_ID_ACTION, $referrerId);
    }

    public function getReferredId() {
        return $this->get(self::REFERRER_ID_ACTION);
    }

    private function set(string $key, $value): void {
        session([$key => $value]);
    }

    private function get(string $key) {
        return session($key);
    }
}
