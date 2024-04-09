<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminLogManagementController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_activity_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("admin-log-management.php", compact("seo", "features"));
    }
}
