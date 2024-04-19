<?php

namespace Src\Controllers;

use Src\Configs\Firebase;
use Src\Configs\Hash;
use Src\Configs\UploadedFile;
use Src\Exceptions\NotFoundException;
use Src\Models\Seo;
use Src\Models\User;
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
        $id = query("id");
        if (empty($id)) throw new NotFoundException();
        $user = $this->userRepo->find($id);
        if (empty($user)) throw new NotFoundException();
        echo view("pages.admin-user-details", compact("seo", "features", "user"));
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
        $file = new UploadedFile($_FILES["avatar"]);
        $publicImageUrl = "/images/avatar.png";

        // Upload image to firebase storage
        if ($file->isValid) {
            $firebase = new Firebase();
            $response = $firebase->uploadObject($file->getRandomName("userAvatar"), $file->tmpName, false);
            $publicImageUrl = $response["publicUrl"];
        }

        // Create user
        $now = date("Y-m-d H:i:s");
        $emailVerifiedAt = input("need-verify-email") === "" ? date("Y-m-d H:i:s") : null;
        $user = new User("", input("email"), Hash::make(input("password")), input("name"), $publicImageUrl, input("dob"), input("gender"), input("role"), $emailVerifiedAt, $now, $now, null);
        $errors = $this->userRepo->create($user);
        if (count($errors) > 0) {
            flashFromArray($errors);
            reload();
        } else {
            redirect("/admin/mng/users.html");
        }
    }
}
