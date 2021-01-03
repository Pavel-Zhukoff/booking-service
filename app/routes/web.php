<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'rooms'], function () use ($router) {
    $router->get('/', 'RoomsController@showAll');
    $router->get('/{id}', 'RoomsController@showById');
    $router->get('/sort', 'RoomsController@sortBy');
    $router->delete('/{id}', 'RoomsController@delete');
    $router->patch('/{id}', 'RoomsController@update');
    $router->post('/', 'RoomsController@create');
});
