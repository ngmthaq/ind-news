<?php

namespace Src\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $name = "Thang";
        echo view("/pages/home.php", compact("name"));
    }
}
