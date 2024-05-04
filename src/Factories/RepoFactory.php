<?php

namespace Src\Factories;

use Src\Repos\FeatureRepo;
use Src\Repos\FeatureRepoInterface;
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

            case FeatureRepoInterface::class:
                return new FeatureRepo();

            default:
                throw new \Exception(trans("error_repository_factory"));
        }
    }
}
