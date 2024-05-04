<?php

namespace Src\Configs;

class Aes
{
    /**
     * Encrypt Algo
     */
    public const ALGO = "AES-128-CBC";

    /**
     * Encrypt string
     * 
     * @param string $plaintext
     */
    public static function encrypt(string $plaintext)
    {
        $ivlen = openssl_cipher_iv_length($cipher = self::ALGO);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertextRaw = openssl_encrypt($plaintext, $cipher, $_ENV["APP_KEY"], OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac("sha256", $ciphertextRaw, $_ENV["APP_KEY"], true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertextRaw);
        return $ciphertext;
    }

    /**
     * Decrypt string
     * 
     * @param string $ciphertext
     */
    public static function decrypt(string $ciphertext)
    {
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher = self::ALGO);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertextRaw = substr($c, $ivlen + $sha2len);
        $originalPlaintext = openssl_decrypt($ciphertextRaw, $cipher, $_ENV["APP_KEY"], OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac("sha256", $ciphertextRaw, $_ENV["APP_KEY"], true);
        if (hash_equals($hmac, $calcmac)) return $originalPlaintext;
        throw new \Exception(trans("error_aes_decrypt"));
    }
}
