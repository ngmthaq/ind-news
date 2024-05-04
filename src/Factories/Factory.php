<?php

namespace Src\Factories;

abstract class Factory
{
    /**
     * Resolve Factory
     * 
     * @param string $key
     * @return mixed
     */
    abstract function resolve(string $key): mixed;
}
