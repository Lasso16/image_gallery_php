<?php 
require_once __DIR__ . '/../src/entity/imagen.class.php';
$imagenesClientes= [new Imagen('client1.jpg','MISS BELLA'),
new Imagen('client2.jpg','DON PENO', 0),
new Imagen('client3.jpg','SWEETY', 0),
new Imagen('client4.jpg','LADY', 0)];
require_once __DIR__ . '/views/about.view.php';

