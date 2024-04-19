<?php

namespace Src\Factories;

use Src\Controllers\AdminAdManagementController;
use Src\Controllers\AdminAttachmentManagementController;
use Src\Controllers\AdminCategoryManagementController;
use Src\Controllers\AdminDashboardController;
use Src\Controllers\AdminLogManagementController;
use Src\Controllers\AdminPostManagementController;
use Src\Controllers\AdminProfileController;
use Src\Controllers\AdminSettingController;
use Src\Controllers\AdminUserManagementController;
use Src\Controllers\AuthController;
use Src\Controllers\CategoryController;
use Src\Controllers\HomeController;
use Src\Controllers\PostController;
use Src\Controllers\SystemController;
use Src\Exceptions\NotFoundException;
use Src\Repos\FeatureRepoInterface;
use Src\Repos\UserRepoInterface;

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
        list($method, $path) = json_decode($key, true);
        return $this->resolveNormalRoute($path, $method);
    }

    /**
     * Resolve route with controller and action
     * 
     * @param string $path
     * @param string $method
     * @return array
     */
    protected function resolveNormalRoute(string $path, string $method)
    {
        // Default Page = Home Page
        if ($method === "GET" && $path === "/") {
            return [new HomeController(), "index"];
        }

        // Home Page
        if ($method === "GET" && $path === "/index.html") {
            return [new HomeController(), "index"];
        }

        // Login Page
        if ($method === "GET" && $path === "/admin/login.html") {
            return [new AuthController(), "login"];
        }

        // Admin Dashboard Page
        if ($method === "GET" && $path === "/admin/dashboard.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminDashboardController($featureRepo), "index"];
        }

        // Admin User Management Page
        if ($method === "GET" && $path === "/admin/mng/users.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
            return [new AdminUserManagementController($featureRepo, $userRepo), "index"];
        }

        // Admin User Details Page
        if ($method === "GET" && $path === "/admin/mng/users/show.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
            return [new AdminUserManagementController($featureRepo, $userRepo), "show"];
        }

        // Admin Create User Page
        if ($method === "GET" && $path === "/admin/mng/users/create.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
            return [new AdminUserManagementController($featureRepo, $userRepo), "create"];
        }

        // Admin User Edit Page
        if ($method === "GET" && $path === "/admin/mng/users/edit.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
            return [new AdminUserManagementController($featureRepo, $userRepo), "edit"];
        }

        // Admin Category Management Page
        if ($method === "GET" && $path === "/admin/mng/categories.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminCategoryManagementController($featureRepo), "index"];
        }

        // Admin Post Management Page
        if ($method === "GET" && $path === "/admin/mng/posts.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminPostManagementController($featureRepo), "index"];
        }

        // Admin Attachment Management Page
        if ($method === "GET" && $path === "/admin/mng/attachments.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminAttachmentManagementController($featureRepo), "index"];
        }

        // Admin ADS Management Page
        if ($method === "GET" && $path === "/admin/mng/ads.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminAdManagementController($featureRepo), "index"];
        }

        // Admin Activity Management Page
        if ($method === "GET" && $path === "/admin/mng/activities.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminLogManagementController($featureRepo), "index"];
        }

        // Admin Profile Page
        if ($method === "GET" && $path === "/admin/profile.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminProfileController($featureRepo), "index"];
        }

        // Admin Setting Page
        if ($method === "GET" && $path === "/admin/setting.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminSettingController($featureRepo), "index"];
        }

        // PHP Info
        if ($method === "GET" && $path === "/_/system/phpinfo.html") {
            return [new SystemController(), "phpinfo"];
        }

        // Attempt Login Form
        if ($method === "POST" && $path === "/admin/login.html") {
            return [new AuthController(), "verifyLoginForm"];
        }

        // Logout
        if ($method === "POST" && $path === "/logout.html") {
            return [new AuthController(), "logout"];
        }

        // Handle Admin Save Setting
        if ($method === "POST" && $path === "/admin/setting.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            return [new AdminSettingController($featureRepo), "save"];
        }

        // Handle Admin Create New User
        if ($method === "POST" && $path === "/admin/mng/users/create.html") {
            $featureRepo = $this->repoFactory->resolve(FeatureRepoInterface::class);
            $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
            return [new AdminUserManagementController($featureRepo, $userRepo), "add"];
        }

        // Resolve Dynamic Route or 404 Not Found
        return $this->resolveDynamicRoute($path, $method);
    }

    /**
     * Resolve dynamic route with controller and action
     * 
     * @param string $path
     * @param string $method
     * @return array
     */
    protected function resolveDynamicRoute(string $path, string $method): array
    {
        // Dynamic Category Page
        if ($method === "GET" && preg_match("/^\/categories\/[a-zA-Z0-9-]+.html$/", $path)) {
            $slug = str_replace("/categories/", "", $path);
            $slug = str_replace(".html", "", $slug);
            $slug = htmlentities($slug);
            return [new CategoryController(), "index", [$slug]];
        }

        // Dynamic Post Page
        if ($method === "GET" && preg_match("/^\/posts\/[a-zA-Z0-9-]+.html$/", $path)) {
            $slug = str_replace("/posts/", "", $path);
            $slug = str_replace(".html", "", $slug);
            $slug = htmlentities($slug);
            return [new PostController(), "index", [$slug]];
        }

        // 404 Not Found
        throw new NotFoundException();
    }
}
