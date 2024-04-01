<?php

namespace Src\Exceptions;

class ServiceUnavailableException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(503, isset($message) ? $message : trans("error_503"), []);
    }
}
