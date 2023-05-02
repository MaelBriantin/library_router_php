<?php

namespace Core;

use Exception;
use MongoDB\Client;

class Connection
{
    public function __construct()
    {

    }

    protected static $connection = null;

    public static function get()
    {
        if (!self::$connection) {
            try {
                $uri = "mongodb://localhost:27017";
                $client = new Client($uri);
                self::$connection = $client->selectDatabase('library');
            } catch (Exception $e) {
                echo jsonResponse('Database ERROR:' . $e->getMessage());
                die();
            }
        }

        return self::$connection;
    }

    protected static function createConnection()
    {

    }
}