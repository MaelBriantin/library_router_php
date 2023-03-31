<?php

use http\Env\Response;
use JetBrains\PhpStorm\NoReturn;

function base_path($path)
{
    return BASE_PATH . $path;
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "<pre>";

    die();
}

function env($const){
    $env = parse_ini_file(base_path('.env'));
    return $env[$const];
};

function uri($index)
{
    return parse_url($_SERVER['REQUEST_URI'])[$index] ?? '';
}

function request_method()
{
    return $_SERVER['REQUEST_METHOD'];
}

function abort($code = 404, $value = [])
{
    http_response_code($code);
//    echo "<h1>$code</h1>";
//    echo 'Not found';
    echo return_json($value);
    die();
}

function view($path, $attributes)
{
    extract($attributes);
    require base_path('views/' . $path);
}

function return_json($value)
{
    if (!env('DEBUG_MODE')) header('Content-Type: application/json; charset=utf-8');
    return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
