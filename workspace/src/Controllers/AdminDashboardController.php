<?php

namespace Src\Controllers;

use Src\Models\Auth;
use Src\Models\Seo;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() === false) redirect("/admin/login.html");
        $seo = new Seo(trans("dashboard_title"), "", "", "", "");
        echo view("admin/dashboard.php", compact("seo"));
    }
}
