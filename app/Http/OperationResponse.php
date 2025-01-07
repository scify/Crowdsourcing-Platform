<?php

namespace App\Http;

/**
 * Class OperationResponse
 */
class OperationResponse {
    public function __construct(public $status, public $data) {}
}
