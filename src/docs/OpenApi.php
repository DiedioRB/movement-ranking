<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Ranking API",
    version: "1.0.0",
    description: "API for movement ranking results"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Local server"
)]
class OpenApi {}

// This class is used to setup the OpenApi library