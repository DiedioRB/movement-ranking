<?php

namespace App\Core;

use App\Config\DatabaseConnection;
use PDO;

abstract class BaseModel
{
    // Database link setup as an Active Record
    protected static string $table;
    protected array $attributes;

    public function __construct(array $data = []) {
        $this->attributes = $data;
    }

    protected static function connection() : PDO
    {
        return DatabaseConnection::getConnection();
    }

    // Finds an item by its ID
    public static function find(int $id) : ?static
    {
        $table = static::$table;
        $sql = "SELECT * FROM $table WHERE id = :id";
        $query = self::connection()->prepare($sql);
        $query->execute([
            'id' => $id,
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $response = $result ? new static($result) : null;
        return $response;
    }

    // Same as find(), but also returns 404 if no items were found
    public static function findOrFail(int $id) : ?static
    {
        $result = self::find($id);

        if($result == null){
            echo Response::notFound();
            exit;
        }
        return $result ?: null;
    }

    // Makes it easier to access the attributes within $attributes
    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function toArray() : array {
        return $this->$attributes;
    }
}