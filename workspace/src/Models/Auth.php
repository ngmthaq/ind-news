<?php

namespace Src\Models;

use Src\Configs\Aes;
use Src\Configs\Database;

class Auth extends User
{
    public const AUTH_KEY = "PHPAUTHID";

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
        $time = time() + 60 * 60 * 24 * 30; // 30 days
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $params = [$email, md5($password)];
        $stm = $db->setSql($sql)->setParams($params)->exec();
        $data = $stm->fetch();
        if (empty($data)) return null;
        $user = User::fromArray(arraySnakeToCamel($data));
        setcookie(self::AUTH_KEY, Aes::encrypt(json_encode($user)), $time, "/");
        return $user;
    }

    /**
     * Handle check user login
     * 
     * @return bool
     */
    public static function check(): bool
    {
        $cipher = $_COOKIE[self::AUTH_KEY];
        if (empty($cipher)) return false;
        $cookie = Aes::decrypt($cipher);
        $credentials = json_decode($cookie, true);
        $email = $credentials["email"];
        $password = $credentials["password"];
        $db = new Database();
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $params = [$email, $password];
        $stm = $db->setSql($sql)->setParams($params)->exec();
        $data = $stm->fetch();
        return isset($data);
    }

    /**
     * Handle logout
     * 
     * @return bool
     */
    public function logout(): bool
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
