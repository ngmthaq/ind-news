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
    return file_exists(ROOT . "/prod.log");
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
    header("Refresh:0; url=$url");
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
    require_once(ROOT . "/resources/views/pages/" . $_path);
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
    require(ROOT . "/resources/views/partials/" . $_path);
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
    $url = str_replace("/public", "", $_SERVER["REDIRECT_URL"]);
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
        require_once(ROOT . "/resources/views/pages/error.php");
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
 * Get lang data
 * 
 * @return array
 */
function getLangData(): array
{
    $lang = query(App::LANG_KEY) ?? input(App::LANG_KEY) ?? App::LANG_DEFAULT;
    $path = ROOT . "/resources/lang/" . $lang . ".php";
    if (!file_exists($path)) $path = ROOT . "/resources/lang/" . App::LANG_DEFAULT . ".php";
    $data = require($path);
    return $data;
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
    foreach ($placeholders as $key => $value) $string = str_replace(":" . $key, $value, $string);
    return $string;
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
