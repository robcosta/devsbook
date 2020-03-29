<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@sigin');
$router->get('/login', 'LoginController@sigup');
