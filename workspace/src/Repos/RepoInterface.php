<?php

namespace Src\Repos;

interface RepoInterface
{
    /**
     * Get all records
     */
    public function all(): array;

    /**
     * Get first record
     */
    public function first(): mixed;
}
