<?php

namespace App\Exceptions;

use Faker\Provider\Base;

class CourierListException extends BaseException
{
    public function __construct(string $message, int $statusCode = 500)
    {
        parent::__construct($message, $statusCode);
    }
}
