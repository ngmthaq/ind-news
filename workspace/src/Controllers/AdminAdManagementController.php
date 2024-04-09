<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminAdManagementController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_ads_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("admin-ad-management.php", compact("seo", "features"));
    }
}
