<?php

namespace Src\Factories;

use Src\Controllers\AdminDashboardController;
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

            case "/_/system/phpinfo.html":
                // PHP Info
                return [new SystemController(), "phpinfo"];

            default:
                // 404 Page Not Found
                throw new NotFoundException();
        }
    }
}
