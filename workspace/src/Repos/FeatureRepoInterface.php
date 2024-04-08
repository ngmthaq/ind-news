<?php

namespace Src\Repos;

use Src\Models\Feature;

interface FeatureRepoInterface extends RepoInterface
{
    /**
     * Get all features
     * 
     * @return Feature[]
     */
    public function all(): array;
}
