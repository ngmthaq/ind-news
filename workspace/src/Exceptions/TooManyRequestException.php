<?php

namespace Src\Exceptions;

class TooManyRequestException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(429, isset($message) ? $message : trans("error_429"), []);
    }
}
