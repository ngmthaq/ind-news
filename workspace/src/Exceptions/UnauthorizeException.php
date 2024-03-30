<?php

namespace Src\Exceptions;

class UnauthorizeException extends Exception
{
    public function __construct(string $message = "Vui lòng đăng nhập để thực hiện hành động này")
    {
        parent::__construct(401, $message, []);
    }
}
