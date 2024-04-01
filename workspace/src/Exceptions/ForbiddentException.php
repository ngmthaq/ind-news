<?php

namespace Src\Exceptions;

class ForbiddentException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(403, isset($message) ? $message : trans("error_403"), []);
    }
}
