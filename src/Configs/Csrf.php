<?php

namespace Src\Configs;

use Src\Exceptions\BadRequestException;

class Csrf
{
    /**
     * Token Key Name
     */
    public const TOKEN_KEY = "X-CSRF-Token";

    /**
     * Init CSRF Token
     * 
     * @return void
     */
    public static function init(): void
    {
        if (empty($_SESSION[self::TOKEN_KEY])) {
            $_SESSION[self::TOKEN_KEY] = generateRandomString(128);
        }
    }

    /**
     * Check CSRF Token
     * 
     * @return void
     */
    public static function check(): void
    {
        if (strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
            $token = $_SESSION[self::TOKEN_KEY];
            $userToken = input(self::TOKEN_KEY);
            $details = [self::TOKEN_KEY => "Token Missmatch"];
            if (empty($token)) throw new BadRequestException($details);
            if (empty($userToken)) throw new BadRequestException($details);
            if ($token !== $userToken) throw new BadRequestException($details);
        }
    }

    /**
     * Generate X-CSRF-Token hidden input
     * 
     * @return string
     */
    public static function input(): string
    {
        $name = self::TOKEN_KEY;
        $value = $_SESSION[self::TOKEN_KEY];
        return "<input type='hidden' name='$name' value='$value' />";
    }

    /**
     * Generate X-CSRF-Token meta tag
     * 
     * @return string
     */
    public static function meta(): string
    {
        $name = self::TOKEN_KEY;
        $value = $_SESSION[self::TOKEN_KEY];
        return "<meta name='$name' content='$value' />";
    }
}
