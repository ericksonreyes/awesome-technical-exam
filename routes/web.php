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

/**
 * @var $router Router
 */
$router->get('/', 'HomeController@indexAction');
$router->get('/v1/api/users', 'GitlabController@indexAction');