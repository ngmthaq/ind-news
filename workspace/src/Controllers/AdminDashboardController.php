<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminDashboardController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_dashboard"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("admin-dashboard.php", compact("seo", "features"));
    }
}
