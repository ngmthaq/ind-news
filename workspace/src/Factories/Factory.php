<?php

namespace Src\Factories;

use Src\Controllers\Controller;

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
