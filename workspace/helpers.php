<?php

use eftec\bladeone\BladeOne;
use Src\Configs\App;
use Src\Configs\Csrf;
use Src\Exceptions\NotFoundException;
use Src\Factories\RouterFactory;

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
            echo "\n===============\n";
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
    return $_ENV["APP_ENV"] === "production";
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
 * @param string | null $defaultValue
 * @return mixed
 */
function input(string $key = null, string | null $defaultValue = null): mixed
{
    $data = xss($_POST);
    if ($key === null) return $data;
    if (isset($data[$key])) return $data[$key];
    return $defaultValue;
}

/**
 * Handle $_GET data
 * 
 * @param string $key
 * @param string | null $defaultValue
 * @return mixed
 */
function query(string $key = null, string | null $defaultValue = null): mixed
{
    $data = xss($_GET);
    if ($key === null) return $data;
    if (isset($data[$key])) return $data[$key];
    return $defaultValue;
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
    exit();
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
    header("Location: $url", true, 302);
    exit();
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
 * @param string $path
 * @param array $data
 * @return string
 */
function view(string $path, array $data = []): string
{
    ob_end_clean();
    ob_start();
    http_response_code(200);
    header("Content-Type: text/html; charset=utf-8");
    $viewPath = ROOT . "/resources/views";
    $cachedPath = ROOT . "/resources/cached";
    $blade = new BladeOne($viewPath, $cachedPath, isProd() ? BladeOne::MODE_AUTO : BladeOne::MODE_DEBUG);
    $blade->pipeEnable = true;
    echo $blade->run($path, $data);
    $html = ob_get_contents();
    ob_end_clean();
    return minify($html);
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
        throw new NotFoundException("Máy chủ không thể tìm thấy bất kỳ tập tin tương ứng trên hệ thống");
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
    $method = strtoupper($_SERVER["REQUEST_METHOD"]);
    $url = str_replace("/public", "", $_SERVER["REDIRECT_URL"]);
    $key = json_encode([$method, $url]);
    $routerFactory = new RouterFactory();
    list($controller, $action, $argv) = $routerFactory->resolve($key);
    $argv = $argv ?? [];
    call_user_func_array([$controller, $action], $argv);
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
        echo view("pages.error", compact("code", "message", "details"));
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
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Get lang code
 * 
 * @return string
 */
function getLangCode(): string
{
    return input(App::LANG_KEY) ?? query(App::LANG_KEY) ?? $_COOKIE[App::LANG_KEY] ?? App::LANG_DEFAULT;
}

/**
 * Get lang data
 * 
 * @return array
 */
function getLangData(): array
{
    $lang = getLangCode();
    $path = ROOT . "/resources/lang/" . $lang . ".php";
    if (!file_exists($path)) $path = ROOT . "/resources/lang/" . App::LANG_DEFAULT . ".php";
    $data = require($path);
    return $data;
}

/**
 * Get lang data in json format
 * 
 * @return string
 */
function getLangJsonData(): string
{
    $lang = input(App::LANG_KEY) ?? query(App::LANG_KEY) ?? $_COOKIE[App::LANG_KEY] ?? App::LANG_DEFAULT;
    $path = ROOT . "/resources/lang/" . $lang . ".php";
    if (!file_exists($path)) $path = ROOT . "/resources/lang/" . App::LANG_DEFAULT . ".php";
    $data = require($path);
    return json_encode($data);
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
    $file = getLangData();
    $string = $file[$key];
    foreach ($placeholders as $key => $value) $string = str_replace("{{" . $key . "}}", $value, $string);
    return $string ?? $key;
}

/**
 * Compress image ("image/jpeg", "image/gif", "image/png")
 * 
 * @param string $source
 * @param string $destination
 * @param int $quality
 * @return bool
 */
function compressImage(string $source, string $destination, int $quality = 75): bool
{
    $info = getimagesize($source);
    $info = getimagesize($source);
    if ($info["mime"] == "image/jpeg") {
        $image = imagecreatefromjpeg($source);
    } elseif ($info["mime"] == "image/gif") {
        $image = imagecreatefromgif($source);
    } elseif ($info["mime"] == "image/png") {
        $image = imagecreatefrompng($source);
    } else {
        throw new \Exception(trans("error_compress_image"));
    }
    return imagejpeg($image, $destination, $quality);
}

/**
 * Get/Set old form data input
 * 
 * @param string $key
 * @param string $data
 * @return string
 */
function old(string $key, string $data = null): string
{
    if (empty($_SESSION["_old"])) $_SESSION["_old"] = [];

    if (isset($data)) {
        $_SESSION["_old"][$key] = $data;
    } else {
        $data = $_SESSION["_old"][$key];
        unset($_SESSION["_old"][$key]);
    }

    return $data ?? "";
}

/**
 * Get/Set flash message
 * 
 * @param string $key
 * @param string $data
 * @return string
 */
function flash(string $key, string $message = null): string
{
    if (empty($_SESSION["_flash"])) $_SESSION["_flash"] = [];

    if (isset($message)) {
        $_SESSION["_flash"][$key] = $message;
    } else {
        $message = $_SESSION["_flash"][$key];
        unset($_SESSION["_flash"][$key]);
    }

    return $message ?? "";
}

/**
 * Get/Set flash message
 * 
 * @param array $messages
 * @return array
 */
function flashFromArray(array $messages): array
{
    foreach ($messages as $key => $message) flash($key, $message);
    return $messages;
}

/**
 * Convert string from camelCase to snake_case
 * 
 * @param string $input
 * @return string
 */
function camelToSnake(string $input): string
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
}

/**
 * Convert string from snake_case to camelCase
 * 
 * @param string $input
 * @return string
 */
function snakeToCamel(string $input): string
{
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
}

/**
 * Convert array from camelCase to snake_case
 * 
 * @param array $input
 * @return array
 */
function arrayCamelToSnake(array $input): array
{
    $result = [];
    foreach ($input as $key => $value) {
        if (gettype($value) === "array") {
            $result[camelToSnake($key)] = arrayCamelToSnake($value);
        } else {
            $result[camelToSnake($key)] = $value;
        }
    }
    return $result;
}

/**
 * Convert array from snake_case to camelCase
 * 
 * @param array $input
 * @return array
 */
function arraySnakeToCamel(array $input): array
{
    $result = [];
    foreach ($input as $key => $value) {
        if (gettype($value) === "array") {
            $result[snakeToCamel($key)] = arraySnakeToCamel($value);
        } else {
            $result[snakeToCamel($key)] = $value;
        }
    }
    return $result;
}

/**
 * Convert string to slug
 * 
 * @param string $string
 * @param string $symbol
 * @return string
 */
function convertStringToSlug(string $string, string $symbol = '-'): string
{
    if (empty($string)) throw new \Exception("");
    $character_a = array('à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ');
    $character_e = array('è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ');
    $character_i = array('ì', 'í', 'ị', 'ỉ', 'ĩ');
    $character_o = array('ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ');
    $character_u = array('ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ');
    $character_y = array('ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ');
    $character_d = array('đ');
    $character_symbol = array('!', '@', '%', '^', '*', '(', ')', '+', '=', '<', '>', '?', '/', ', ', '.', ':', ';', '|', '"', '&', '#', '[', ']', '~', '$', '_', '__', '--', ' ');
    $alias = mb_strtolower($string, 'UTF-8');
    $alias = trim($alias);
    $alias = str_replace($character_a, 'a', $alias);
    $alias = str_replace($character_e, 'e', $alias);
    $alias = str_replace($character_i, 'i', $alias);
    $alias = str_replace($character_o, 'o', $alias);
    $alias = str_replace($character_u, 'u', $alias);
    $alias = str_replace($character_y, 'y', $alias);
    $alias = str_replace($character_d, 'd', $alias);
    $symbol_modify = '-';
    if (isset($symbol)) $symbol_modify = $symbol;
    $alias = str_replace($character_symbol, $symbol_modify, $alias);
    $alias = preg_replace('/--+/', $symbol_modify, $alias);
    $alias = preg_replace('/__+/', $symbol_modify, $alias);
    return $alias . $symbol . time();
}

/**
 * Get current url
 * 
 * @return string
 */
function getCurrentUrl(): string
{
    return str_replace("/public", "", $_SERVER["REDIRECT_URL"]);
}

/**
 * Get X-CSRF input
 * 
 * @return string
 */
function csrfInput(): string
{
    return Csrf::input();
}
