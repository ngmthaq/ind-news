<?php

namespace Src\Controllers;

class AdminCmsController extends Controller
{
    protected array $navItems;

    public function __construct()
    {
        $this->navItems = [];
    }
}
