<?php

namespace Src\Factories;

use Src\Controllers\AdminDashboardController;
use Src\Controllers\AuthController;
use Src\Controllers\HomeController;
use Src\Controllers\SystemController;
use Src\Exceptions\NotFoundException;
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
        switch ($key) {
            case "/":
                // Default Page = Home Page
                $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
                return [new HomeController($userRepo), "index"];

            case "/index.html":
                // Home Page
                $userRepo = $this->repoFactory->resolve(UserRepoInterface::class);
                return [new HomeController($userRepo), "index"];

            case "/admin/login.html";
                // Login Page
                return [new AuthController(), "login"];

            case "/admin/dashboard.html";
                // Admin Dashboard Page
                return [new AdminDashboardController(), "index"];

            case "/_/system/phpinfo.html":
                // PHP Info
                return [new SystemController(), "phpinfo"];

            default:
                // 404 Page Not Found
                throw new NotFoundException();
        }
    }
}
