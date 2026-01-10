<?php

namespace App\Classes\Core;

interface Middleware
{
    public function handle(Request $request): bool;
}