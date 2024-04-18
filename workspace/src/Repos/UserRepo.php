<?php

namespace Src\Repos;

use PDO;
use Src\Configs\Database;
use Src\Models\Pagination;
use Src\Models\User;

class UserRepo extends Repo implements UserRepoInterface
{
    public function all(): array
    {
        $db = new Database();
        $stm = $db->setSql("SELECT * FROM users")->exec();
        $data = $stm->fetchAll();
        return array_map(function ($feature) {
            return User::fromArray(arraySnakeToCamel($feature));
        }, $data);
    }

    public function paginate(string $filter, int $limit, int $offset): Pagination
    {
        $db = new Database();

        // Get totals item number
        $db->setSql("SELECT count(*) as totalUsers FROM users WHERE email LIKE :email OR name LIKE :name");
        $db->setParam(":email", "%$filter%", PDO::PARAM_STR);
        $db->setParam(":name", "%$filter%", PDO::PARAM_STR);
        $stm = $db->exec();
        $data = $stm->fetch();
        $totalUsers = $data["totalUsers"];

        // Paginate
        $db->setSql("SELECT * FROM users WHERE email LIKE :email OR name LIKE :name ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $db->setParam(":email", "%$filter%", PDO::PARAM_STR);
        $db->setParam(":name", "%$filter%", PDO::PARAM_STR);
        $db->setParam(":limit", $limit, PDO::PARAM_INT);
        $db->setParam(":offset", $offset, PDO::PARAM_INT);
        $stm = $db->exec();
        $data = $stm->fetchAll();
        $users = array_map(function ($feature) {
            return User::fromArray(arraySnakeToCamel($feature));
        }, $data);

        return new Pagination($users, $totalUsers, $limit, $offset);
    }

    public function create(User $user): array
    {
        $response = [];
        if (filter_var($user->email, FILTER_VALIDATE_EMAIL) === false) {
            $response["email"] = trans("error_invalidate_email");
        }
        if (trim($user->name) === "") {
            $response["name"] = trans("error_required_field");
        }
        if (trim($user->dob) === "") {
            $response["dob"] = trans("error_required_field");
        }
        if (trim($user->gender) === "") {
            $response["gender"] = trans("error_required_field");
        }
        if (trim($user->role) === "") {
            $response["role"] = trans("error_required_field");
        }
        if (trim($user->password) === "") {
            $response["password"] = trans("error_required_field");
        }
        if (count($response) > 0) {
            return $response;
        }

        return [];
    }
}
