<?php

namespace Src\Exceptions;

abstract class Exception extends \Exception
{
    /**
     * Error Details
     */
    protected array $details;

    public function __construct(int $code, string $message, array $details)
    {
        parent::__construct($message, $code);
        $this->details = $details;
    }

    /**
     * Get error details
     * 
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
