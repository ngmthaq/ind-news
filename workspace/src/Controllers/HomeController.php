<?php

namespace Src\Controllers;

use Src\Models\Seo;

class HomeController extends Controller
{
    public function index()
    {
        $name = "Thang";
        $seo = new Seo(trans("title_homepage"), "", "", "", "");
        echo view("pages.home", compact("name",  "seo"));
    }
}
