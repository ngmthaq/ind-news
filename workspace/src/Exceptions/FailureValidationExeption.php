<?php

namespace Src\Exceptions;

class FailureValidationExeption extends Exception
{
    public function __construct(array $details)
    {
        parent::__construct(422, "Dữ liệu gửi lên không đúng định dạng", $details);
    }
}
