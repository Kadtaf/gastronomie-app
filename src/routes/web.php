<?php

use App\Classes\Core\Route;

return [

    // Home
    Route::get('/', 'HomeController@index'),

    // Auth
    Route::get('/login', 'AuthController@login'),
    Route::post('/login', 'AuthController@login')->middleware('csrf'),

    Route::get('/register', 'AuthController@register'),
    Route::post('/register', 'AuthController@register')->middleware('csrf'),

    Route::get('/logout', 'AuthController@logout'),

    // Mot de passe oublié
    Route::get('/forgot-password', 'AuthController@forgotPassword'),
    Route::post('/forgot-password', 'AuthController@forgotPassword')->middleware('csrf'),

    Route::get('/reset-password/{token}', 'AuthController@resetPassword'),
    Route::post('/reset-password/{token}', 'AuthController@resetPassword')->middleware('csrf'),

    // Admin group
    [
        'prefix' => '/admin',
        'middleware' => ['auth', 'admin'],
        'routes' => [
            Route::get('/dashboard', 'AdminController@dashboard'),
            Route::post('/user/delete/{id}', 'AdminController@deleteUser')->middleware('csrf'),
        ]
    ],

];