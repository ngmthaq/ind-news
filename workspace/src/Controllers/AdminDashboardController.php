<?php

namespace Src\Controllers;

use Src\Models\Auth;
use Src\Models\Seo;

class AdminDashboardController extends AdminCmsController
{
    public function index()
    {
        $user = Auth::user();
        if (empty($user)) redirect("/admin/login.html", ["callbackUrl" => "/admin/dashboard.html"]);
        if ($user->isAdmin() === false) redirect("/");
        $seo = new Seo(trans("dashboard_title"), "", "", "", "");
        echo view("admin/dashboard.php", compact("seo"));
    }
}
