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

$router->get('/perfil/{id}/amigos','ProfileController@friends');
$router->get('/perfil/{id}/follow','ProfileController@follow');
$router->get('/perfil/{id}','ProfileController@index');
$router->get('/perfil','ProfileController@index');
$router->get('/amigos','ProfileController@friends');

$router->get('/sair','LoginController@logout');

//$router->get('/pesquisa', 'HomeController@search');
//$router->get('/perfil);
//$router->get('/fotos);
//$router->get('/config);