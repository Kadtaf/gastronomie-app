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

    // Page forbidden (publique)
    Route::get('/forbidden', 'ErrorController@forbidden'),

    // Routes protégées
    Route::get('/user/profile', 'UserController@profile')
        ->middleware('auth'),

    Route::get('/admin/dashboard', 'AdminController@dashboard')
        ->middleware('auth')
        ->middleware('admin'),      

    // Admin group
    [
        'prefix' => '/admin',
        'middleware' => ['auth', 'admin'],
        'routes' => [
            Route::get('/dashboard', 'AdminController@dashboard'),
            Route::post('/user/delete/{id}', 'AdminController@deleteUser')->middleware('csrf'),
        ]
    ],

    //Recipe routes
    [
        'prefix' => '/recipe',
        'routes' => [
            Route::get('/index', 'RecipeController@index'),
            Route::get('/show/{id}', 'RecipeController@show'),
            Route::get('/add', 'RecipeController@add')->middleware('auth'),
            Route::post('/add', 'RecipeController@add')->middleware('auth')->middleware('csrf'),
        ]
    ],

];