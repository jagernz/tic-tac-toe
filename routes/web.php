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
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function ($router) {
    $router->get('games', 'ApiController@getAllGames');
    $router->post('games', 'ApiController@startNewGame');
    $router->get('games/{game_id}', 'ApiController@getGame');
    $router->put('games/{game_id}', 'ApiController@makeMove');
    $router->delete('games/{game_id}', 'ApiController@deleteGame');
});
