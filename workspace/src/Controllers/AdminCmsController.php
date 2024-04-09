<?php

namespace Src\Controllers;

use Src\Models\Auth;
use Src\Repos\FeatureRepoInterface;

class AdminCmsController extends Controller
{
    protected FeatureRepoInterface $featureRepo;

    public function __construct(FeatureRepoInterface $featureRepo)
    {
        $this->featureRepo = $featureRepo;
    }

    protected function checkAuthAndPermission()
    {
        $user = Auth::user();
        if (empty($user)) redirect("/admin/login.html", ["callbackUrl" => "/admin/dashboard.html"]);
        if ($user->isAdmin() === false) redirect("/");
    }
}
