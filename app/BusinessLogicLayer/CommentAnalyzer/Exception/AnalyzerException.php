<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\CommentAnalyzer\Exception;

class AnalyzerException extends \Exception {
    public function __construct($message = '', $code = 0, ?\Exception $exception = null) {
        parent::__construct($message, $code, $exception);
    }

    public function __toString(): string {
        return self::class . sprintf(': [%s]: %s%s', $this->code, $this->message, PHP_EOL);
    }
}
