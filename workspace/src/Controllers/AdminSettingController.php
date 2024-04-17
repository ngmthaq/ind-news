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
        $time = time() + 60 * 60 * 24 * 30; // 30 days
        $theme = input("theme");
        $theme = in_array($theme, ["light", "dark"]) ? $theme : "light";
        setcookie("PHPTHEME", input("theme"), $time, "/");
        redirect("/admin/setting.html");
    }
}
