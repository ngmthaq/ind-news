<?php

namespace Src\Exceptions;

class BadRequestException extends Exception
{
    public function __construct(array $details)
    {
        parent::__construct(400, "Yêu cầu truy cập của bạn không hợp lệ", $details);
    }
}
