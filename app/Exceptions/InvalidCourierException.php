<?php

namespace App\Exceptions;


class InvalidCourierException extends BaseException
{
    public function __construct(string $message, int $statusCode = 500)
    {
        parent::__construct($message, $statusCode);
    }

}
