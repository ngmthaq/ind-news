<?php

namespace Src\Factories;

use Src\Controllers\AdminAdManagementController;
use Src\Controllers\AdminAttachmentManagementController;
use Src\Controllers\AdminCategoryManagementController;
use Src\Controllers\AdminDashboardController;
use Src\Controllers\AdminLogManagementController;
use Src\Controllers\AdminPostManagementController;
use Src\Controllers\AdminProfileController;
use Src\Controllers\AdminUserManagementController;
use Src\Controllers\AuthController;
use Src\Controllers\HomeController;
use Src\Controllers\SystemController;
use Src\Exceptions\NotFoundException;
use Src\Repos\FeatureRepoInterface;

class RouterFactory extends Factory
{
    private RepoFactory $repoFactory;

    public function __construct()
    {
        $this->repoFactory = new RepoFactory();
    }

    /**
     * Resolve route with controller and action
     * 
     * @param string $key
     * @return array
     */
    public function resolve(string $key): array
    {
        switch ($key) {
            case "/":
                // Default Page = Home Page
                return [new HomeController(), "index"];

            case "/index.html":
                // Home Page
                return [new HomeController(), "index"];

            case "/logout.html";
                // Logout
                return [new AuthController(), "logout"];

            case "/admin/login.html";
                // Login Page
                return [new AuthController(), "login"];

            case "/admin/dashboard.html";
                // Admin Dashboard Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminDashboardController($featureRepo), "index"];

            case "/admin/mng/users.html";
                // Admin User Management Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminUserManagementController($featureRepo), "index"];

            case "/admin/mng/categories.html";
                // Admin Category Management Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminCategoryManagementController($featureRepo), "index"];

            case "/admin/mng/posts.html";
                // Admin Post Management Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminPostManagementController($featureRepo), "index"];

            case "/admin/mng/attachments.html";
                // Admin Attachment Management Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminAttachmentManagementController($featureRepo), "index"];

            case "/admin/mng/ads.html";
                // Admin ADS Management Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminAdManagementController($featureRepo), "index"];

            case "/admin/mng/activities.html";
                // Admin Activity Management Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminLogManagementController($featureRepo), "index"];

            case "/admin/profile.html";
                // Admin Profile Page
                $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
                return [new AdminProfileController($featureRepo), "index"];

            case "/_/system/phpinfo.html":
                // PHP Info
                return [new SystemController(), "phpinfo"];

            default:
                // 404 Page Not Found
                throw new NotFoundException();
        }
    }
}
