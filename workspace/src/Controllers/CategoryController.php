<?php

namespace Src\Controllers;

use Src\Models\Seo;

class CategoryController extends Controller
{
    public function index(string $slug)
    {
        $name = $slug;
        $seo = new Seo(trans("title_category"), "", "", "", "");
        echo view("category.php", compact("name",  "seo"));
    }
}
