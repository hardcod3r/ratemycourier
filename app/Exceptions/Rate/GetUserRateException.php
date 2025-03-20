<?php

namespace App\Exceptions\Rate;

use App\Exceptions\BaseException;

class GetUserRateException extends BaseException
{
    public function __construct($message = "Failed to get user rate.", $code = 400)
    {
        parent::__construct($message, $code);
    }

}
