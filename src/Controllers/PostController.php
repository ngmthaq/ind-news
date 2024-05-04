<?php

namespace Src\Controllers;

use Src\Models\Seo;

class PostController extends Controller
{
    public function index(string $slug)
    {
        $name = $slug;
        $seo = new Seo(trans("title_post"), "", "", "", "");
        echo view("pages.post", compact("name",  "seo"));
    }
}
