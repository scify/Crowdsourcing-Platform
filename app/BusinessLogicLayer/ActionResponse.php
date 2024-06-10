<?php

namespace App\BusinessLogicLayer;

class ActionResponse {
    public $status;
    public $data;

    /**
     * ActionResponse constructor.
     */
    public function __construct($status, $data) {
        $this->status = $status;
        $this->data = $data;
    }
}
