<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminUserManagementController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_user_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("admin-user-management.php", compact("seo", "features"));
    }
}
