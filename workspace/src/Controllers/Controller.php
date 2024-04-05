<?php

namespace Src\Controllers;

use Src\Configs\Csrf;

abstract class Controller
{
    public function __construct()
    {
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
        if (empty($_SESSION["old"])) $_SESSION["old"] = [];
        if (strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
            foreach (input() as $name => $value) {
                old($name, $value);
            }
        }
    }
}
