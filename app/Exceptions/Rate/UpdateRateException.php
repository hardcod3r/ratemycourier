<?php

namespace App\Exceptions\Rate;

use App\Exceptions\BaseException;

class UpdateRateException extends BaseException
{
    public function __construct($message = "Vote could not be updated.", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
