<?php

namespace Src\Exceptions;

class ServiceUnavailableException extends Exception
{
    public function __construct(string $message = "Máy chủ đang trong quá trình bảo trì, vui lòng quay lại sau ít phút")
    {
        parent::__construct(503, $message, []);
    }
}
