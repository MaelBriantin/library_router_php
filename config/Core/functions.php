<?php

use http\Env\Response;
use JetBrains\PhpStorm\NoReturn;

function basePath($path): string
{
    return BASE_PATH . $path;
}

function dd($value)
{
    //echo jsonResponse($value);
    echo var_dump($value);
    die();
}

function env($const)
{
    $env = parse_ini_file(basePath('.env'));
    return $env[$const];
};

function uri($index)
{
    return parse_url($_SERVER['REQUEST_URI'])[$index] ?? '';
}

function requestMethod()
{
    return $_SERVER['REQUEST_METHOD'];
}

function abort($code = 404, $value = [])
{
    http_response_code($code);
//    echo "<h1>$code</h1>";
//    echo 'Not found';
    echo jsonResponse($value);
    die();
}

function view($path, $attributes)
{
    extract($attributes);
    require basePath('views/' . $path);
}

function jsonResponse($value)
{
    if (!env('DEBUG_MODE')) header('Content-Type: application/json; charset=utf-8');
    return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function singularize($string) {
    $exceptions = ['libraries' => 'library',
                    'properties' => 'property'];

    if (array_key_exists($string, $exceptions)) {
        return $exceptions[$string];
    } else if(str_ends_with($string, 's')) {
        $singular = preg_replace('/s$/', '', $string); // enlève le "s" final
        if (preg_match('/news$/i', $singular)) { // gère le cas particulier de "news"
            $singular = preg_replace('/s$/i', '', $singular);
        } elseif (preg_match('/people$/i', $singular)) { // gère le cas particulier de "people"
            $singular = 'person';
        } elseif (preg_match('/(quiz)zes$/i', $singular)) { // gère le cas particulier de "quiz" et "buzz"
            $singular = preg_replace('/(quiz)zes$/i', '$1', $singular);
        } elseif (preg_match('/(matr)ices$/i', $singular)) { // gère le cas particulier de "matrix"
            $singular = preg_replace('/(matr)ices$/i', '$1ix', $singular);
        } elseif (preg_match('/(vert|ind)ices$/i', $singular)) { // gère le cas particulier de "index"
            $singular = preg_replace('/(vert|ind)ices$/i', '$1ex', $singular);
        } elseif (preg_match('/^(ox)en/i', $singular)) { // gère le cas particulier de "ox"
            $singular = preg_replace('/^(ox)en/i', '$1', $singular);
        } elseif (preg_match('/(alias)es$/i', $singular)) { // gère le cas particulier de "alias"
            $singular = preg_replace('/(alias)es$/i', '$1', $singular);
        } else { // gère les autres cas en enlevant simplement le "s" final
            $singular = preg_replace('/s$/', '', $singular);
        }
        return $singular;
    } else {
        return $string;
    }
}
function _toCamelCase($string) {
    if (str_contains( $string, '_')){
        $words = explode('_', strtolower($string));
        $camelCaseString = '';

        foreach ($words as $key => $word) {
            $camelCaseString .= $key === 0 ? $word : ucfirst($word);
        }
        return $camelCaseString;
    } else {
        return $string;
    }
}

function returnRequestJson() {
    $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($content_type, 'application/json') === 0) {
        $json_data = file_get_contents('php://input');
        return json_decode($json_data, true);
    }
}

/**
 * @param array $keysToRemove Array that contain all the keys the method will remain
 * @param array $inArray Array where modifications will be applied
 * @param bool|null $isAssocArray Is the array an associative array
 * @return array
 */
function exclude(array $keysToRemove, array $inArray, bool $isAssocArray=null): array
{
    $result = [];
    if ($isAssocArray) {
        foreach ($inArray as $element) {
            $keys = array_fill_keys($keysToRemove, '');
            $result[] = array_intersect_key($element, $keys);
        }
    } else {
        $keys = array_fill_keys($keysToRemove, '');
        return array_intersect_key($inArray, $keys);
    }
    return $result;
}

/**
 * @param array $keysToKeep Array that contain all the keys the method will maintain
 * @param array $inArray Array where modifications will be applied
 * @param bool|null $isAssocArray Is the array an associative array
 * @return array
 */
function only(array $keysToKeep, array $inArray, bool $isAssocArray=null): array
{
    $result = [];
    if ($isAssocArray) {
        foreach ($inArray as $element) {
            $keys = array_fill_keys($keysToKeep, '');
            $result[] = array_intersect_key($element, $keys);
        }
    } else {
        $keys = array_fill_keys($keysToKeep, '');
        return array_intersect_key($inArray, $keys);
    }
    return $result;
}