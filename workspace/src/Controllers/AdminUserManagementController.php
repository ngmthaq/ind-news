<?php

namespace Src\Controllers;

use Src\Models\Seo;
use Src\Repos\FeatureRepoInterface;
use Src\Repos\UserRepoInterface;

class AdminUserManagementController extends AdminCmsController
{
    protected UserRepoInterface $userRepo;

    public function __construct(FeatureRepoInterface $featureRepo, UserRepoInterface $userRepo)
    {
        parent::__construct($featureRepo);
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_user_management"), "", "", "", "");
        $features = $this->featureRepo->all();
        $users = $this->userRepo->all();
        echo view("pages.admin-user-management", compact("seo", "features", "users"));
    }
}
