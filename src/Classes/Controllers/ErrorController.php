<?php

namespace App\Classes\Controllers;

class ErrorController extends AbstractController
{
    public function forbidden(): void
    {
        http_response_code(403);

        $this->renderView('errors/forbidden', [], layout: 'main');
    }

    public function notFound(): void
    {
        http_response_code(404);

        $this->renderView('errors/404', [], layout: 'main');
    }
}