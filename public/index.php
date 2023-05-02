<?php
require 'vendor/autoload.php';
// App config
require __DIR__ . '/../config/config.php';
// Routes
require basePath('routes/routes.php');

$bookConnection = \Core\Connection::get()->selectCollection('books');
