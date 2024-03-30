<?php

try {
    /**
     * Auloload
     */
    require_once("./vendor/autoload.php");

    /**
     * Initialize session data
     */
    session_start();

    /**
     * Turn on output buffering
     */
    ob_start();

    /**
     * Debugger
     * 
     * @return void
     */
    function debug(): void
    {
        ob_end_clean();
        $argv = func_get_args();
        echo "<pre>";
        foreach ($argv as $arg) {
            print_r($arg);
            echo "\n===============";
        }
        echo "<pre/>";
        die();
    }

    /**
     * Prevent XSS
     * 
     * @param array $array
     * @return array
     */
    function xss(array $array): array
    {
        $output = [];
        foreach ($array as $key => $value) {
            if (gettype($value) === "string") {
                $output[$key] = htmlentities(trim($value));
            } elseif (gettype($value) === "array") {
                $output[$key] = xss($value);
            } else {
                $output[$key] = $value;
            }
        }
        return $output;
    }

    /**
     * Handle $_POST data
     * 
     * @param string $key
     * @return mixed
     */
    function input(string $key = null): mixed
    {
        $data = xss($_POST);
        if ($key === null) return $data;
        if (isset($data[$key])) return $data[$key];
        return null;
    }

    /**
     * Handle $_GET data
     * 
     * @param string $key
     * @return mixed
     */
    function query(string $key = null): mixed
    {
        $data = xss($_GET);
        if ($key === null) return $data;
        if (isset($data[$key])) return $data[$key];
        return null;
    }

    /**
     * Handle $_SESSION data
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    function session(string $key = null, mixed $value = null): mixed
    {
        if (isset($value)) {
            $_SESSION[$key] = $value;
            return $value;
        } else {
            $data = xss($_SESSION);
            if ($key === null) return $data;
            if (isset($data[$key])) return $data[$key];
            return null;
        }
    }

    /**
     * Get route string
     * 
     * @param string $path
     * @param array $queries
     * @return string
     */
    function route(string $path, array $queries = []): string
    {
        if (count($queries) === 0) return $path;
        return $path . "/?" . http_build_query($queries);
    }

    /**
     * Reload
     * 
     * @return void
     */
    function reload(): void
    {
        header("Refresh:0");
    }

    /**
     * Redirect
     * 
     * @param string $path
     * @param array $queries
     * @return void
     */
    function redirect(string $path, array $queries = []): void
    {
        $url = route($path, $queries);
        header("Refresh:0; url=$url");
    }

    /**
     * Excute application
     * 
     * @return void
     */
    function execute(): void
    {
        $url = isset($_SERVER["REDIRECT_URL"]) ? $_SERVER["REDIRECT_URL"] : "/";
        $route_factory = new Src\Factories\RouterFactory();
        call_user_func($route_factory->resolve($url));
    }

    execute();
} catch (\Throwable $th) {
    if ($th instanceof \Src\Exceptions\NotFoundException) {
        echo "404 - Page Not Found";
    } else {
        echo "500 - Server Internal Error";
    }
}
