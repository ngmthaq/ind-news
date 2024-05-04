<?php

namespace Src\Exceptions;

class NotFoundException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(404, isset($message) ? $message : trans("error_404"), []);
    }
}
