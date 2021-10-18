<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\UserRegistered;
use Tests\TestCase;

class NotificationTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_notification_sending() {
        $user = User::findOrFail(1);
        $user->notify(new UserRegistered());
    }
}
