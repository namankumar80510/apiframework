<?php

declare(strict_types=1);

namespace App\Library;

/**
 * Class Router
 * 
 * Handles routing for the application.
 */
class Router
{
    /**
     * @var array Stores the registered routes
     */
    private array $routes = [];

    /**
     * Adds a new route to the router.
     *
     * @param string $method The HTTP method for the route
     * @param string $path The path for the route
     * @param callable $handler The handler function for the route
     * @return void
     */
    public function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    /**
     * Dispatches the request to the appropriate route handler.
     *
     * @param string $method The HTTP method of the request
     * @param string $uri The URI of the request
     * @return mixed The result of the route handler
     */
    public function dispatch(string $method, string $uri): mixed
    {
        if (!isset($this->routes[$method])) {
            $this->notFound();
        }

        // Parse the URI to separate path from query parameters
        $parsedUri = parse_url($uri);
        $path = $parsedUri['path'] ?? '/';

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = $this->convertRouteToRegex($route);
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);

                // Parse query parameters
                $queryParams = [];
                if (isset($parsedUri['query'])) {
                    parse_str($parsedUri['query'], $queryParams);
                }

                // Merge route parameters with query parameters
                $params = array_merge($matches, [$queryParams]);

                return $handler(...$params);
            }
        }

        $this->notFound();
    }

    /**
     * Converts a route pattern to a regular expression.
     *
     * @param string $route The route pattern to convert
     * @return string The resulting regular expression
     */
    private function convertRouteToRegex(string $route): string
    {
        return '#^' . preg_replace('/\([^)]+\)/', '([^/]+)', $route) . '$#';
    }

    /**
     * Handles the case when no matching route is found.
     *
     * @return void
     */
    private function notFound(): void
    {
        respond([
            'message' => '404 Not Found',
            'status' => 'error',
            'data' => []
        ], 404);
    }
}
