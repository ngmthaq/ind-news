<?php

namespace Src\Factories;

use Src\Repos\IUserRepo;
use Src\Repos\Repo;
use Src\Repos\UserRepo;

class RepoFactory extends Factory
{
    public function resolve(string $key): Repo
    {
        switch ($key) {
            case IUserRepo::class:
                return new UserRepo();

            default:
                throw new \Exception("Đã xảy ra lỗi khi chạy Repository");
        }
    }
}
