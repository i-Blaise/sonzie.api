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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['prefix'=>'api/v1'], function() use($router){

    $router->get('/', 'SonzieController@index');
    $router->post('/countComment/{id}', 'SonzieController@countComment');
    $router->post('/fetchComment/{id}', 'SonzieController@fetchComment');
    $router->get('/fetchPortfolio', 'SonzieController@fetchPortfolio');
    $router->post('/fetchSinglePortfolio/{id}', 'SonzieController@fetchSinglePortfolio');
    $router->post('/createComment', 'SonzieController@createComment');
    $router->post('/contactUs', 'SonzieController@contactUs');
    $router->get('/getLatestContact', 'SonzieController@getLatestContact');


});