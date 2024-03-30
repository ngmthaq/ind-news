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
     * Service available
     */
    $is_service_available = true;
    if (!$is_service_available) throw new Src\Exceptions\ServiceUnavailableException();

    /**
     * Execute Application
     */
    execute();
} catch (\Throwable $th) {
    /**
     * Error Handler
     */
    if ($th instanceof \Src\Exceptions\Exception) {
        error($th->getMessage(), $th->getDetails(), $th->getCode());
    } else {
        $is_prod = isProd();
        if ($is_prod) {
            $message = $th->getMessage();
            $trace = $th->getTraceAsString();
            $date = gmdate("Y-m-d", time());
            $time = gmdate("H:i:s", time());
            $log_file = "./prod.log";
            $info_message = "[$date $time UTC] ERROR: $message\n$trace\n\n";
            error_log($info_message, 3, $log_file);
        }
        error(
            $is_prod ? "Máy chủ đã xảy ra lỗi, vui lòng thử lại sau" : $th->getMessage(),
            $is_prod ? [] : $th->getTrace(),
            500
        );
    }
}
