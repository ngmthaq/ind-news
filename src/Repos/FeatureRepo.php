<?php

namespace Src\Repos;

use Src\Configs\Database;
use Src\Models\Feature;

class FeatureRepo extends Repo implements FeatureRepoInterface
{
    public function all(): array
    {
        $db = new Database();
        $sql = "SELECT * FROM features";
        $stm = $db->setSql($sql)->exec();
        $data = $stm->fetchAll();
        return array_map(function ($feature) {
            return Feature::fromArray(arraySnakeToCamel($feature));
        }, $data);
    }
}
