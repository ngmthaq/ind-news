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
        echo view("admin-setting.php", compact("seo", "features"));
    }
}
