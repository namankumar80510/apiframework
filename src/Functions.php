<?php

declare(strict_types=1);

use App\Library\Database;
use App\Library\Config;
use App\Library\Response;

/**
 * Escapes a string for safe output in HTML.
 *
 * @param string $string The string to be escaped.
 * @return string The escaped string.
 */
function esc(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirects to the specified URL.
 *
 * @param string $url The URL to redirect to.
 * @param int $statusCode The HTTP status code for the redirect (default: 302).
 * @return void
 */
function redirect(string $url, int $statusCode = 302): void
{
    header("Location: $url", true, $statusCode);
    exit;
}

/**
 * Dumps the given data and terminates the script.
 *
 * @param mixed $data The data to be dumped.
 * @return void
 */
function dd($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}

/**
 * Retrieves a configuration value or the entire configuration array.
 *
 * @param string|null $key The configuration key in dot notation (optional).
 * @return mixed The configuration value, entire array, or null if key not found.
 * @throws Exception If the config file is not found.
 */
function config(?string $key = null): mixed
{
    return Config::get($key);
}

/**
 * Returns a PDO instance for database operations.
 *
 * @return PDO The PDO instance.
 * @throws Exception If the database connection fails.
 */
function db(): PDO
{
    return Database::db();
}

/**
 * Sends a JSON response.
 *
 * @param mixed $data The data to be included in the response.
 * @param int $statusCode The HTTP status code (default: 200).
 * @param array $headers Additional headers to be sent with the response.
 * @return void
 */
function respond($data, int $statusCode = 200, array $headers = []): void
{
    Response::json($data, $statusCode, $headers);
}