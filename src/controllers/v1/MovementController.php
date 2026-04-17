<?php

namespace App\Controllers\v1;

use App\Models\Movement;
use App\Core\Response;
use OpenApi\Attributes as OA;

class MovementController
{

    #[OA\Get(
        path: "/v1/movements/{id}",
        summary: "Lists a movement's value ranking.",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "The movement's ID or name",
                schema: new OA\Schema(oneOf: [
                    new OA\Schema(type: "integer"),
                    new OA\Schema(type: "string")
                ])
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Returns the score ranking of a movement. Might return an empty list if no ranking is found.",
            ),
            new OA\Response(
                response: 404,
                description: "The movement searched does not exists.",
            )
        ]
    )]
    static public function getRanking(int|string $id) : string
    {
        if(is_numeric($id))
        {
            // By id
            $movement = Movement::findOrFail($id);
        }else{
            // By movement name
            $movement = Movement::findByName($id);
        }
        if(!$movement){
            // When no movement is found, returns 404
            return Response::notFound();
        }
        $id = $movement->id;

        // Searches the movement ranking
        $ranking = Movement::ranking($id);
        return Response::json($ranking);
    }
}