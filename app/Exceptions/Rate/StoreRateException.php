<?php
namespace App\Exceptions\Rate;

use App\Exceptions\BaseException;

class StoreRateException extends BaseException
{
    public function __construct($message = "Vote could not be stored.", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
