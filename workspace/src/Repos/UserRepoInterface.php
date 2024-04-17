<?php

namespace Src\Repos;

use Src\Models\User;

interface UserRepoInterface extends RepoInterface
{
    /**
     * Get all features
     * 
     * @return User[]
     */
    public function all(): array;

    /**
     * Get all features
     * 
     * @return User[]
     */
    public function paginate(): array;
}
