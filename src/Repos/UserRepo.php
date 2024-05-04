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
        // Validate file type
        $response = [];
        if (trim($user->email) === "") {
            $response["email"] = trans("error_required_field");
        } elseif (filter_var($user->email, FILTER_VALIDATE_EMAIL) === false) {
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

        // Insert to the database
        $db = new Database();
        $db->setSql("INSERT INTO users "
            . "(email, password, name, avatar, dob, gender, role, email_verified_at, created_at, updated_at) VALUES "
            . "(:email, :password, :name, :avatar, :dob, :gender, :role, :email_verified_at, :created_at, :updated_at)");
        $db->setParam(":email", $user->email, PDO::PARAM_STR);
        $db->setParam(":password", $user->password, PDO::PARAM_STR);
        $db->setParam(":name", $user->name, PDO::PARAM_STR);
        $db->setParam(":avatar", $user->avatar, PDO::PARAM_STR);
        $db->setParam(":dob", $user->dob, PDO::PARAM_STR);
        $db->setParam(":gender", $user->gender, PDO::PARAM_INT);
        $db->setParam(":role", $user->role, PDO::PARAM_INT);
        $db->setParam(":email_verified_at", $user->emailVerifiedAt, PDO::PARAM_NULL | PDO::PARAM_STR);
        $db->setParam(":created_at", $user->createdAt, PDO::PARAM_STR);
        $db->setParam(":updated_at", $user->updatedAt, PDO::PARAM_STR);
        $db->exec();

        return [];
    }

    public function find(int $id): User|null
    {
        $db = new Database();
        $db->setSql("SELECT * FROM users WHERE id = :id LIMIT 1");
        $db->setParam(":id", $id, PDO::PARAM_INT);
        $stm = $db->exec();
        $data = $stm->fetch();
        if (empty($data)) return null;
        return User::fromArray(arraySnakeToCamel($data));
    }
}
