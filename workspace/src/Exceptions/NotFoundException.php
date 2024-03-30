<?php

namespace Src\Exceptions;

class NotFoundException extends Exception
{
    public function __construct(string $message = "We cannot found the page you are looking for")
    {
        parent::__construct(404, $message, []);
    }
}
