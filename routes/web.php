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

// demo routes
Route::get('/', function () {
    return view('demo.index');
});

Route::get('/user_member', function () {
    return view('demo.indexUserMember');
});

Route::get('/user_not_member', function () {
    return view('demo.indexUserNotMember');
});

Route::get('/user_author', function () {
    return view('demo.indexUserAuthor');
});

Route::get('/pricing', function () {
    return view('demo.pricing');
});

Route::prefix('internal-api')->group(function () {

    Route::any('login', 'AuthProcess@login');

    Route::any('register', 'AuthProcess@register');

    Route::any('get-authors', 'AuthProcess@getAuthors');

    Route::any('proceed', 'AuthProcess@proceed');
});

Route::get('/api/{any?}', 'AuthProcess@index');
