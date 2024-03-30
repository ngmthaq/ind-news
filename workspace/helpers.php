<?php

/**
 * Debugger
 * 
 * @return void
 */
function debug(): void
{
    if (!isProd()) {
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
}

/**
 * Minify output
 *
 * @param string $buffer
 * @return string
 */
function minify(string $buffer): string
{
    if (isProd()) {
        $search = [
            "/\>[^\S ]+/s",
            "/[^\S ]+\</s",
            "/(\s)+/s",
            "/<!--(.|\s)*?-->/",
        ];
        $replace = [">", "<", "\\1", "",];
        $buffer = preg_replace($search, $replace, $buffer);
    }
    return $buffer;
}

/**
 * Check env is production
 * 
 * @return bool
 */
function isProd(): bool
{
    return file_exists("./prod.log");
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
 * Json Response
 * 
 * @param array $data
 * @param array $headers
 * @return void
 */
function json(array $data, array $headers = []): void
{
    http_response_code(200);
    foreach ($headers as $header) header($header);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data);
}

/**
 * HTML Response
 * 
 * @param string $_path
 * @param array $_data
 * @return void
 */
function view(string $_path, array $_data = []): void
{
    ob_end_clean();
    ob_start();
    http_response_code(200);
    header("Content-Type: text/html; charset=utf-8");
    extract($_data);
    require_once("./resources/views" . $_path);
    $_html = ob_get_contents();
    ob_end_clean();
    echo minify($_html);
}

/**
 * Attachment Response
 * 
 * @param string $attachment_location
 * @return void
 */
function attachment(string $attachment_location): void
{
    if (file_exists($attachment_location)) {
        ob_end_clean();
        http_response_code(200);
        header("Cache-Control: public");
        header("Content-Type: " . mime_content_type($attachment_location));
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length: " . filesize($attachment_location));
        header("Content-Disposition: attachment; filename=" . basename($attachment_location));
        readfile($attachment_location);
        exit();
    } else {
        throw new Src\Exceptions\NotFoundException("Máy chủ không thể tìm thấy bất kỳ tập tin tương ứng trên hệ thống");
    }
}

function assets(string $path): string
{
    $time = isProd() ? strtotime("today midnight") : time();
    return "$path?t=$time";
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

/**
 * Error Response
 * 
 * @param string $message
 * @param array $details
 * @param int $code
 * @return void
 */
function error(string $message, array $details, int $code): void
{
    ob_end_clean();
    $url = isset($_SERVER["REDIRECT_URL"]) ? $_SERVER["REDIRECT_URL"] : "/";
    $is_need_json = str_ends_with($url, ".json");
    http_response_code($code);
    if ($is_need_json) {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(compact("code", "message", "details"));
    } else {
        ob_start();
        header("Content-Type: text/html; charset=utf-8");
        require_once("./resources/views/pages/error.php");
        $_html = ob_get_contents();
        ob_end_clean();
        echo minify($_html);
    }
}
