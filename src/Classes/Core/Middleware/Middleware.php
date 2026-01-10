<?php

namespace App\Classes\Core\Middleware;

use App\Classes\Core\Request;

interface Middleware
{
    public function handle(Request $request): bool;
}