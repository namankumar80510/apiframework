<?php

declare(strict_types=1);

namespace App\Controller;

class WelcomeController
{
    /**
     * just a welcome message
     *
     * @return void
     */
    public function index()
    {
        return respond([
            'message' => 'Welcome to the ' . config('app.name'),
            'status' => 'success',
            'data' => [
                'name' => config('app.name'),
                'version' => config('app.version'),
                'author' => config('app.author'),
            ]
        ]);
    }
}
