<?php

namespace Src\Controllers;

use Src\Models\Auth;
use Src\Repos\FeatureRepoInterface;

class AdminCmsController extends Controller
{
    protected FeatureRepoInterface $featureRepo;

    public function __construct(FeatureRepoInterface $featureRepo)
    {
        parent::__construct();
        $this->featureRepo = $featureRepo;
    }

    /**
     * Check auth and permission for CMS route
     * 
     * @return void
     */
    protected function checkAuthAndPermission(): void
    {
        $user = Auth::user();
        if (empty($user)) redirect("/admin/login.html", ["callbackUrl" => getCurrentUrl()]);
        if ($user->isActive() === false) redirect("/email/verify.html");
        if ($user->isAdmin() === false) redirect("/");
    }
}
