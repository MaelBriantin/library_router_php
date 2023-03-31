<?php

namespace Core;

use PDO;
use PDOException;

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
                self::$connection = self::createConnection();
            } catch (PDOException $e) {
                // Log db error message
                // $e->getMessage()
                throw new PDOException('Database ERROR:' . $e->getMessage());
            }
        }

        return self::$connection;
    }

    protected static function createConnection()
    {
        return new PDO(env('DB_DSN'), env('DB_USERNAME'), env('DB_PASSWORD'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}