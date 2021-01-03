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
    $router->get('/sort', 'RoomsController@sortBy');
    $router->get('/{id}', 'RoomsController@showById');
    $router->delete('/{id}', 'RoomsController@delete');
    $router->get('/', 'RoomsController@showAll');
    $router->post('/', 'RoomsController@create');
});

$router->group(['prefix' => 'reserves'], function () use ($router) {
    $router->get('/room/{id}', 'ReservationsController@showByRoomId');
    $router->delete('/{id}', 'ReservationsController@delete');
    $router->get('/', 'ReservationsController@showAll');
    $router->post('/', 'ReservationsController@create');
});
