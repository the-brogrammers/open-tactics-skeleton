<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->welcome();
});

/*
|--------------------------------------------------------------------------
| Accounts
|--------------------------------------------------------------------------
*/

$app->get('accounts/me', [
    'middleware' => 'auth',
    'uses' => 'AccountController@me'
]);

$app->post('accounts', 'AccountController@create');

/*
|--------------------------------------------------------------------------
| Sessions
|--------------------------------------------------------------------------
*/

$app->post('sessions', 'SessionController@create');
