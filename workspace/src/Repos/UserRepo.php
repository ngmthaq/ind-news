<?php

namespace Src\Repos;

use Src\Configs\Database;
use Src\Models\User;

class UserRepo extends Repo implements UserRepoInterface
{
    public function all(): array
    {
        $db = new Database();
        $sql = "SELECT * FROM users";
        $stm = $db->setSql($sql)->exec();
        $data = $stm->fetchAll();
        return array_map(function ($feature) {
            return User::fromArray(arraySnakeToCamel($feature));
        }, $data);
    }

    public function paginate(): array
    {
        $db = new Database();
        $sql = "SELECT * FROM users";
        $stm = $db->setSql($sql)->exec();
        $data = $stm->fetchAll();
        return array_map(function ($feature) {
            return User::fromArray(arraySnakeToCamel($feature));
        }, $data);
    }
}
