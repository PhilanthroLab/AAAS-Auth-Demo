<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('internal-api')->group(function () {

    Route::any('login', 'AuthProcess@login');

    Route::any('register', 'AuthProcess@register');

    Route::any('get-authors', 'AuthProcess@getAuthors');

    Route::any('proceed', 'AuthProcess@proceed');
});

Route::get('/{any?}', 'AuthProcess@index');
