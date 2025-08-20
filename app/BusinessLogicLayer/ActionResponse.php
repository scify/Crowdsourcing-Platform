<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer;

class ActionResponse {
    /**
     * ActionResponse constructor.
     */
    public function __construct(public $status, public $data) {}
}
