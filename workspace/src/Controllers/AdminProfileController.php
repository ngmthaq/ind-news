<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminProfileController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_profile"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("pages.admin-profile", compact("seo", "features"));
    }
}
