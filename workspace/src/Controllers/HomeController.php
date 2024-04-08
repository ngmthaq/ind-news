<?php

namespace Src\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $name = "Thang";
        $title = "Hello World";
        echo view("home.php", compact("name",  "title"));
    }
}
