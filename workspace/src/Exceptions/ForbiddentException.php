<?php

namespace Src\Exceptions;

class ForbiddentException extends Exception
{
    public function __construct(string $message = "Bạn không được cấp quyền để thực hiện hành động này")
    {
        parent::__construct(403, $message, []);
    }
}
