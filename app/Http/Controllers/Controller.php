<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Otsuka API",
 *     version="1.0.0"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="api_auth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your JWT token in the format **Bearer &lt;token&gt;**"
 * )
 */

abstract class Controller {}
