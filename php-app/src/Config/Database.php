<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            return new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_STR_PARAM => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: " . $e->getMessage());
        }
    }
}
