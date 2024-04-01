<?php

use Src\Configs\App;

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
 * @return string
 */
function json(array $data, array $headers = []): string
{
    ob_end_clean();
    ob_start();
    http_response_code(200);
    foreach ($headers as $header) header($header);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data);
    $json = ob_get_contents();
    ob_end_clean();
    return $json;
}

/**
 * HTML Response
 * 
 * @param string $_path
 * @param array $_data
 * @return string
 */
function view(string $_path, array $_data = []): string
{
    ob_end_clean();
    ob_start();
    http_response_code(200);
    header("Content-Type: text/html; charset=utf-8");
    extract($_data);
    require_once("./resources/views/pages/" . $_path);
    $_html = ob_get_contents();
    ob_end_clean();
    return minify($_html);
}

/**
 * Import partial component
 * 
 * @param string $_path
 * @param array $_data
 * @return string
 */
function partial(string $_path, array $_data = []): void
{
    extract($_data);
    require("./resources/views/partials/" . $_path);
}

/**
 * Attachment Response
 * 
 * @param string $attachmentLocation
 * @return string
 */
function attachment(string $attachmentLocation): string
{
    if (file_exists($attachmentLocation)) {
        ob_end_clean();
        ob_start();
        http_response_code(200);
        header("Cache-Control: public");
        header("Content-Type: " . mime_content_type($attachmentLocation));
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length: " . filesize($attachmentLocation));
        header("Content-Disposition: attachment; filename=" . basename($attachmentLocation));
        readfile($attachmentLocation);
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    } else {
        throw new Src\Exceptions\NotFoundException("Máy chủ không thể tìm thấy bất kỳ tập tin tương ứng trên hệ thống");
    }
}

/**
 * Get full assets path
 * 
 * @param string $path
 * @return string
 */
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
    $routerFactory = new Src\Factories\RouterFactory();
    call_user_func($routerFactory->resolve($url));
}

/**
 * Error Response
 * 
 * @param string $message
 * @param array $details
 * @param int $code
 * @return string
 */
function error(string $message, array $details, int $code): string
{
    ob_end_clean();
    ob_start();
    $url = isset($_SERVER["REDIRECT_URL"]) ? $_SERVER["REDIRECT_URL"] : "/";
    $isNeedJson = str_ends_with($url, ".json");
    http_response_code($code);
    if ($isNeedJson) {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(compact("code", "message", "details"));
    } else {
        header("Content-Type: text/html; charset=utf-8");
        require_once("./resources/views/pages/error.php");
    }
    $output = ob_get_contents();
    ob_end_clean();
    return minify($output);
}

/**
 * Generate random string
 * 
 * @param int $length
 * @return string
 */
function generateRandomString(int $length = 16): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Translation
 * 
 * @param string $key
 * @param array $placeholders
 * @return string
 */
function trans(string $key, array $placeholders = []): string
{
    $lang = query(App::LANG_KEY) ?? input(App::LANG_KEY) ?? App::LANG_DEFAULT;
    $file = require("./resources/lang/" . $lang . ".php");
    $string = $file[$key];
    foreach ($placeholders as $key => $value) {
        $string = str_replace(":" . $key, $value, $string);
    }
    return $string;
}
