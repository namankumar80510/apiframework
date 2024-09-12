<?php

declare(strict_types=1);

namespace App\Library;

class Response
{
    /**
     * Send a JSON response.
     *
     * @param mixed $data The data to be encoded as JSON.
     * @param int $statusCode The HTTP status code (default: 200).
     * @param array $headers Additional headers to be sent.
     * @return void
     */
    public static function json($data, int $statusCode = 200, array $headers = []): void
    {
        // Set the content type to JSON
        header('Content-Type: application/json');

        // Set the HTTP status code
        http_response_code($statusCode);

        // Set additional headers
        foreach ($headers as $name => $value) {
            header("$name: $value");
        }

        // Encode the data as JSON and output it
        echo json_encode($data);
        exit;
    }
}
