<?php
$router->get ('', 'app/controllers/index.php');
$router->get ('about', 'app/controllers/about.php');
$router->get ('asociados', 'app/controllers/asociados.php');
$router->get ('blog', 'app/controllers/blog.php');
$router->get ('contact', 'app/controllers/contact.php');
$router->get ('galeria', 'app/controllers/galeria.php');
$router->get ('post', 'app/controllers/single_post.php');

$router->post('galeria/nueva', 'app/controllers/galeria_nueva.php');
$router->post('contact/enviar', 'app/controllers/contact-enviar.php');