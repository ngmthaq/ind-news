<?php

namespace Src\Models;

use PDO;
use Src\Configs\Aes;
use Src\Configs\Database;

class Auth extends User
{
    public const AUTH_KEY = "PHPAUTHTOKEN";

    /**
     * Handle verify user login
     * 
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public static function attempt(string $email, string $password): User|null
    {
        $db = new Database();
        $db->setSql("SELECT * FROM users WHERE email = :email AND password = :password AND deleted_at IS NULL LIMIT 1 OFFSET 0");
        $db->setParam(":email", $email, PDO::PARAM_STR);
        $db->setParam(":password", md5($password), PDO::PARAM_STR);
        $stm = $db->exec();
        $data = $stm->fetch();
        if (empty($data)) return null;
        $user = User::fromArray(arraySnakeToCamel($data));
        $time = time() + 60 * 60 * 24 * 30; // 30 days
        setcookie(self::AUTH_KEY, Aes::encrypt(json_encode($user)), $time, "/");
        return $user;
    }

    /**
     * Handle get authenticated user
     * 
     * @return User|null
     */
    public static function user(): User|null
    {
        try {
            $cipher = $_COOKIE[self::AUTH_KEY];
            if (empty($cipher)) return null;
            $cookie = Aes::decrypt($cipher);
            $credentials = json_decode($cookie, true);
            $email = $credentials["email"];
            $password = $credentials["password"];
            if (empty($email)) return null;
            if (empty($password)) return null;
            $db = new Database();
            $db->setSql("SELECT * FROM users WHERE email = :email AND password = :password AND deleted_at IS NULL LIMIT 1 OFFSET 0");
            $db->setParam(":email", $email, PDO::PARAM_STR);
            $db->setParam(":password", $password, PDO::PARAM_STR);
            $stm = $db->exec();
            $data = $stm->fetch();
            if (empty($data)) return null;
            $user = User::fromArray(arraySnakeToCamel($data));
            $time = time() + 60 * 60 * 24 * 30; // 30 days
            setcookie(self::AUTH_KEY, $cipher, $time, "/");
            return $user;
        } catch (\Throwable $th) {
            self::logout();
            return null;
        }
    }

    /**
     * Handle check user login
     * 
     * @return bool
     */
    public static function check(): bool
    {
        $user = self::user();
        return isset($user);
    }

    /**
     * Handle logout
     * 
     * @return bool
     */
    public static function logout(): bool
    {
        try {
            unset($_COOKIE[self::AUTH_KEY]);
            setcookie(self::AUTH_KEY, "", -1, "/");
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
