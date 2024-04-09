<?php

namespace Src\Controllers;

use Src\Models\Seo;

class PostController extends Controller
{
    public function index()
    {
        $name = "Thang";
        $seo = new Seo(trans("title_post"), "", "", "", "");
        echo view("post.php", compact("name",  "seo"));
    }
}
