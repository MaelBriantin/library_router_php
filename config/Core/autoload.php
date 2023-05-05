<?php
// Composer autoload (required for MongoDB)
require basePath('vendor/autoload.php');

// Custom autoload
const CLASS_FOLDER = [
    'Core' => 'config',
    'Traits' => 'src',
    'Controllers' => 'src',
    'Models' => 'src'
];

function folderSrc ($class)
{
    $src = CLASS_FOLDER;
    $namespace = explode('\\', $class)[0];
    if (array_key_exists($namespace, $src)){
        return "$src[$namespace]/";
    }
    else {
        return '';
    }
}

spl_autoload_register(function ($class) {
    $src = folderSrc($class);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require basePath("{$src}{$class}.php");
});

