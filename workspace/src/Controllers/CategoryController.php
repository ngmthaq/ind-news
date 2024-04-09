<?php

namespace Src\Controllers;

use Src\Models\Seo;

class CategoryController extends Controller
{
    public function index()
    {
        $name = "Thang";
        $seo = new Seo(trans("title_category"), "", "", "", "");
        echo view("category.php", compact("name",  "seo"));
    }
}
