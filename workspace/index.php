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
     * @param string $controller_name
     * @param string $action_name
     * @param array $queries
     * @return string
     */
    function route(string $controller_name, string $action_name, array $queries = []): string
    {
        return "/?" . http_build_query(array_merge($queries, ["c" => $controller_name, "a" => $action_name]));
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
     * @param string $controller_name
     * @param string $action_name
     * @param array $queries
     * @return void
     */
    function redirect(string $controller_name, string $action_name, array $queries = []): void
    {
        $url = route($controller_name, $action_name, $queries);
        header("Refresh:0; url=$url");
    }

    /**
     * Get controller instance
     * 
     * @return Src\Controllers\Controller
     */
    function getController(): Src\Controllers\Controller
    {
        $route_controller = query("c");
        $controller_name = isset($route_controller) ? implode("", array_map(
            fn ($string) => ucfirst($string),
            explode("_", $route_controller)
        )) : "Home";
        $full_controller_name = $controller_name . "Controller";
        $controller_autoload = "Src\\Controllers\\$full_controller_name";
        $controller = new $controller_autoload();
        return $controller;
    }

    /**
     * Get action name
     * 
     * @return string
     */
    function getActionName(): string
    {
        $route_action = query("a");
        $action_name = isset($route_action) ? $route_action : "index";
        return $action_name;
    }

    /**
     * Excute application
     * 
     * @return void
     */
    function execute(): void
    {
        $controller = getController();
        $action = getActionName();
        call_user_func(array($controller, $action));
    }

    execute();
} catch (\Throwable $th) {
    throw $th;
}
