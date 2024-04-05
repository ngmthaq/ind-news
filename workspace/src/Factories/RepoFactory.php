<?php

namespace Src\Factories;

use Src\Repos\UserRepo;
use Src\Repos\UserRepoInterface;

class RepoFactory extends Factory
{
    /**
     * Resolve repository
     * 
     * @param string $key
     * @return mixed
     */
    public function resolve(string $key): mixed
    {
        switch ($key) {
            case UserRepoInterface::class:
                return new UserRepo();

            default:
                throw new \Exception(trans("error_repository_factory"));
        }
    }
}
