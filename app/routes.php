<?php
$router->get ('', 'PagesController@index');
$router->get ('about', 'PagesController@about');
$router->get ('blog', 'PagesController@blog');

$router->get('asociados', 'AsociadosController@index', 'ROLE_USER');
$router->post('asociados/nuevo', 'AsociadosController@nuevo', 'ROLE_ADMIN');

$router->get('contact', 'ContactoController@index');
$router->post('contact/enviar', 'ContactoController@enviar');

$router->get ('galeria', 'GaleriaController@index', 'ROLE_USER');
$router->post('galeria/nueva', 'GaleriaController@nueva', 'ROLE_ADMIN');
$router->get ('galeria/:id', 'GaleriaController@show', 'ROLE_USER');

$router->get ('post', 'app/controllers/single_post.php');
$router->get ('post', 'PagesController@post');

$router->get('login', 'AuthController@login');
$router->post('check-login', 'AuthController@checkLogin');
$router->get('logout', 'AuthController@logout', 'ROLE_USER');

$router->get ('registro', 'AuthController@registro');
$router->post('check-registro', 'AuthController@checkRegistro');