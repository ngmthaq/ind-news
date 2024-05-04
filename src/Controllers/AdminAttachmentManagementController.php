<?php

namespace Src\Controllers;

use Src\Models\Seo;

class AdminAttachmentManagementController extends AdminCmsController
{
    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_attachment_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("pages.admin-attachment-management", compact("seo", "features"));
    }
}
