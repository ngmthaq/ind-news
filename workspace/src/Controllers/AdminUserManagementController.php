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
        $filter = query("filter", "");
        $page = (int)query("page", 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = $this->userRepo->paginate($filter, $limit, $offset);
        echo view("pages.admin-user-management", compact("seo", "features", "pagination"));
    }

    public function show()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_user_details"), "", "", "", "");
        $features = $this->featureRepo->all();
        echo view("pages.admin-user-details", compact("seo", "features"));
    }

    public function create()
    {
        $this->checkAuthAndPermission();
        $seo = new Seo(trans("cms_user_create"), "", "", "", "");
        $features = $this->featureRepo->all();
        $defaultPassword = generateRandomString();
        echo view("pages.admin-user-create", compact("seo", "features", "defaultPassword"));
    }

    public function add()
    {
        $this->checkAuthAndPermission();
    }
}
