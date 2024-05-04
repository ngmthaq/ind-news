<?php

namespace Src\Exceptions;

class UnauthorizeException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(401, isset($message) ? $message : trans("error_401"), []);
    }
}
