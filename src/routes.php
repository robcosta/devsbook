<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@sigin');
$router->post('/login', 'LoginController@siginAction');
$router->get('/cadastro', 'LoginController@sigup');
