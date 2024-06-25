<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "petshop api", title: "Digital Genuine Documentation"),
    OA\Server(url: 'http://digitalgenuine.test/', description: "local server"),
    // OA\Server(url: 'http://staging.example.com', description: "staging server"),
    // OA\Server(url: 'http://example.com', description: "production server"),
]

abstract class Controller
{
    
}
