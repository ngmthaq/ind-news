<?php

namespace Src\Controllers;

use Src\Configs\Csrf;

abstract class Controller
{
    public function __construct()
    {
        Csrf::init();
        Csrf::check();
    }
}
