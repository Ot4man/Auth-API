<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Auth-API Documentation",
    version: "1.0.0",
    description: "API de gestion de l'authentification et des profils utilisateurs",
    contact: new OA\Contact(email: "support@example.com")
)]
#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Serveur Local (Artisan Serve)"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
abstract class Controller
{
    //
}
