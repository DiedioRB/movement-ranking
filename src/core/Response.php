<?php

namespace App\Core;

class Response {
    // Returns a json encoded response with custom status
    public static function json($data, $status = 200)
    {
        http_response_code($status);
        header("Content-Type: application/json");
        return json_encode([
            "status" => $status,
            "data" => $data,
        ]);
    }

    // Returns a 404 error
    public static function notFound()
    {
        http_response_code(404);
        header("Content-Type: application/json");
        return json_encode([
            "status" => 404,
            "message" => "Not found",
        ]);
    }
}