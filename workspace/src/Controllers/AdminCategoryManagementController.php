<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminCategoryManagementController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_category_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("pages.admin-category-management", compact("seo", "features"));
    }
}
