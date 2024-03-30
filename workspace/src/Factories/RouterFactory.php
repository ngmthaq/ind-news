<?php

namespace Src\Factories;

use Src\Controllers\HomeController;
use Src\Controllers\SystemController;
use Src\Exceptions\NotFoundException;

class RouterFactory extends Factory
{
    /**
     * Resolve route with controller and action
     * 
     * @param string $key
     * @return array
     */
    public function resolve(string $key): array
    {
        switch ($key) {
            case "/":
                // HomePage
                return [new HomeController(), "index"];

            case "/_system/phpinfo":
                // PHP Info
                return [new SystemController(), "phpinfo"];

            default:
                // 404 Page Not Found
                throw new NotFoundException();
        }
    }
}
