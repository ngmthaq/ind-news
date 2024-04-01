<?php

try {
    /**
     * Auloload
     */
    require_once("./vendor/autoload.php");

    /**
     * Helpers
     */
    require_once("./helpers.php");

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
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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
        $isProd = isProd();
        if ($isProd) {
            $message = $th->getMessage();
            $trace = $th->getTraceAsString();
            $date = gmdate("Y-m-d", time());
            $time = gmdate("H:i:s", time());
            $logFile = "./prod.log";
            $info_message = "[$date $time UTC] ERROR: $message\n$trace\n\n";
            error_log($info_message, 3, $logFile);
        }
        echo error(
            $isProd ? "Máy chủ đã xảy ra lỗi, vui lòng thử lại sau" : $th->getMessage(),
            $isProd ? [] : $th->getTrace(),
            500
        );
    }
}
