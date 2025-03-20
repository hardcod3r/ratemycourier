<?php

namespace App\Exceptions\Rate;

use App\Exceptions\BaseException;

class DeleteRateException extends BaseException
{
    public function __construct($message = "Vote could not be deleted.", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
