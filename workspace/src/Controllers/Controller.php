<?php

namespace Src\Controllers;

use Src\Configs\Csrf;
use Src\Configs\Throttle;

abstract class Controller
{
    public function __construct()
    {
        Throttle::resolve();
        Csrf::init();
        Csrf::check();
        $this->getOldFormData();
    }

    /**
     * Handle set old form data
     * 
     * @return void
     */
    private function getOldFormData(): void
    {
        if (empty($_SESSION["_old"])) $_SESSION["_old"] = [];
        if (strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
            foreach (input() as $name => $value) {
                old($name, $value);
            }
        }
    }
}
