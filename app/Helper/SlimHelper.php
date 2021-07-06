<?php

namespace App\Helper;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * The SlimHelper class is a helper for the Response.
 *
 * It provides common functions, which are used in the api.
 */
class SlimHelper
{
    public function response(Response $response, array $responseData, string $message, int $code)
    {
        $response->getBody()->write(json_encode([
            "data" => $responseData,
            "code" => $code,
            "message" => $message,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
