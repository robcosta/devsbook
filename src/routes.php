<?php
use core\Router;
use src\controllers\HomeController;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/signin', 'LoginController@signin');
$router->post('/signin', 'LoginController@signinAction');

$router->get('/signup', 'LoginController@signup');
$router->post('/signup', 'LoginController@signupAction');

$router->post('/post/new', 'PostController@new');

$router->get('/perfil/{id}','ProfileController@index');
$router->get('/perfil','ProfileController@index');

//$router->get('/pesquisa', 'HomeController@search');
//$router->get('/sair',);
//$router->get('/perfil);
//$router->get('/amigos);
//$router->get('/fotos);
//$router->get('/config);