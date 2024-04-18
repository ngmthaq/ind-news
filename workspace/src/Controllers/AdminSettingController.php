<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminSettingController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_setting"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("pages.admin-setting", compact("seo", "features"));
    }

    public function save()
    {
        redirect("/admin/setting.html");
    }
}
