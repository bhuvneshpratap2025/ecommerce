<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="My Laravel API",
 *     description="API documentation for the Laravel project."
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     description="Sanctum token: use 'Bearer {token}'",
 *     name="Authorization",
 *     in="header",
 *     securityScheme="sanctum"
 * )
 */
class SwaggerInfo
{
    // Just here to hold Swagger annotations
}
