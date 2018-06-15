<?php

namespace App\Http;

/**
 * Class OperationResponse
 * @package app
 * This class holds information about a response sent to a art of the app
 */
class OperationResponse {
    var $status;
    var $data;

    function __construct($status, $data) {
        $this->status = $status;
        $this->data = $data;
    }
}