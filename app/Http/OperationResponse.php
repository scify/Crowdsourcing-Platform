<?php

namespace App\Http;

/**
 * Class OperationResponse
 */
class OperationResponse {
    public $status;
    public $data;

    public function __construct($status, $data) {
        $this->status = $status;
        $this->data = $data;
    }
}
