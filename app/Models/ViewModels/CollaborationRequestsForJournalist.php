<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/25/18
 * Time: 12:42 PM
 */

namespace App\Models\ViewModels;


use App\Models\User;

class CollaborationRequestsForJournalist
{
    public $location;
    public $collaborationResponses;

    public function __construct(User $user, $collaborationResponses) {
        $this->location = $user->location;
        $this->collaborationResponses = $collaborationResponses;
    }
}