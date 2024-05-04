<?php

namespace Src\Configs;

use Src\Exceptions\TooManyRequestException;

class Throttle
{
    /**
     * Token Key Name
     */
    public const KEY = "X-Throttle";
    public const MAX = 30;

    /**
     * Resolve Throttle
     * 
     * @return void
     */
    public static function resolve()
    {
        if (isProd()) {
            if (empty($_SESSION[self::KEY])) {
                $_SESSION[self::KEY] = [
                    "timestamp" => time(),
                    "number" => 1,
                ];
            } else {
                $current_time = time();
                $throttle_start_time = $_SESSION[self::KEY]["timestamp"];
                if ($current_time - $throttle_start_time > 60) {
                    $_SESSION[self::KEY] = [
                        "timestamp" => $current_time,
                        "number" => 1,
                    ];
                } else {
                    $_SESSION[self::KEY]["number"] += 1;
                }
                if ($_SESSION[self::KEY]["number"] > self::MAX) {
                    $_SESSION[self::KEY]["timestamp"] = $current_time;
                    throw new TooManyRequestException();
                }
            }
        }
    }
}
