<?php

namespace App\Config;

use PDO;

class DatabaseConnection
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        // singleton connection
        if(self::$connection == null)
        {
            $host = $_ENV['DB_HOST'];
            $db   = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];

            try{
                self::$connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            }catch(PDOException $e)
            {
                echo Response::json([[
                    "error" => "Failed connecting to database",
                    "message" => $e->getMessage(),
                ]], 500);
                exit;
            }
        }

        return self::$connection;
    }
}