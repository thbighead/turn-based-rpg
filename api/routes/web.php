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

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/', 'PageController@home');

$router->get('log', 'GameController@log');
$router->post('login', 'GameController@login');

$router->post('play', ['middleware' => 'auth', 'uses' => 'GameController@play']);
$router->post('battle', ['middleware' => 'auth', 'uses' => 'GameController@battle']);

$router->post('next_turn', ['middleware' => 'auth', 'uses' => 'BattleController@nextTurn']);
