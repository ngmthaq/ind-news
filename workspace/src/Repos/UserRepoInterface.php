<?php

namespace Src\Repos;

use Src\Models\Pagination;
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
     * @param string $filter
     * @param int $limit
     * @param int $offset
     * @return Pagination
     */
    public function paginate(string $filter, int $limit, int $offset): Pagination;
}
