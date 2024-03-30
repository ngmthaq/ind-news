<?php

namespace Src\Exceptions;

class NotFoundException extends Exception
{
    public function __construct(string $message = "Chúng tôi không thể tìm thấy trang bạn đang tìm kiếm")
    {
        parent::__construct(404, $message, []);
    }
}
