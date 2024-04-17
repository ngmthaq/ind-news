<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminPostManagementController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_post_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("pages.admin-post-management", compact("seo", "features"));
    }
}
