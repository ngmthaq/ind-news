<?php

namespace Src\Configs;

class Hash
{
    /**
     * Hash string
     * 
     * @param string $plain
     * @return string
     */
    public static function make(string $plain): string
    {
        return md5($plain);
    }

    /**
     * Check hash string
     * 
     * @param string $plain
     * @param string $hash
     * @return bool
     */
    public static function check(string $plain, string $hash): bool
    {
        return strcmp(self::make($plain), $hash) === 0;
    }
}
