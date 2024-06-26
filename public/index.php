<?php

try {
    /**
     * ROOT DIR = root folder = var/www/html in docker container
     */
    define("ROOT", str_replace("/public", "", __DIR__));

    /**
     * Auloload
     */
    require_once("../vendor/autoload.php");

    /**
     * Helpers
     */
    require_once("../helpers.php");

    /**
     * Initialize session data
     */
    session_start();

    /**
     * Turn on output buffering
     */
    ob_start();

    /**
     * Initial Dotenv
     */
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT);
    $dotenv->safeLoad();

    /**
     * Service available
     */
    if ($_ENV["APP_AVAILABLE"] !== "true") throw new Src\Exceptions\ServiceUnavailableException();

    /**
     * Execute Application
     */
    execute();
} catch (\Throwable $th) {
    /**
     * Error Handler
     */
    if ($th instanceof \Src\Exceptions\Exception) {
        echo error($th->getMessage(), $th->getDetails(), $th->getCode());
    } else {
        $message = $th->getMessage();
        $trace = $th->getTraceAsString();
        $date = gmdate("Y-m-d", time());
        $time = gmdate("H:i:s", time());
        $logFile = ROOT . "/resources/cached/error.log";
        if (!file_exists($logFile)) touch($logFile);
        $infoMessage = "[$date $time UTC] ERROR: $message\n$trace\n\n";
        error_log($infoMessage, 3, $logFile);
        echo error(
            $isProd ? trans("error_500") : $message,
            $isProd ? [] : $th->getTrace(),
            500
        );
    }
}
