<?php

namespace Src\Factories;

use Src\Controllers\HomeController;
use Src\Controllers\SystemController;
use Src\Exceptions\NotFoundException;
use Src\Repos\IUserRepo;

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
                $userRepo = $this->repoFactory->resolve(IUserRepo::class);
                return [new HomeController($userRepo), "index"];

            case "/index.html":
                // Home Page
                $userRepo = $this->repoFactory->resolve(IUserRepo::class);
                return [new HomeController($userRepo), "index"];

            case "/_system/phpinfo.html":
                // PHP Info
                return [new SystemController(), "phpinfo"];

            default:
                // 404 Page Not Found
                throw new NotFoundException();
        }
    }
}
