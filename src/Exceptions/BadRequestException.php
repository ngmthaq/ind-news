<?php

namespace Src\Exceptions;

class BadRequestException extends Exception
{
    public function __construct(array $details)
    {
        parent::__construct(400, trans("error_400"), $details);
    }
}
