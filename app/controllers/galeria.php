<?php

namespace dwes\app\entity;
use dwes\core\App;
use dwes\app\repository\ImagenRepository;
use dwes\app\repository\CategoriaRepository;
use dwes\app\exceptions\AppException;
use dwes\app\exceptions\FileException;
use dwes\app\exceptions\QueryException;
use dwes\app\utils\File;


$errores = [];
$titulo = "";
$descripcion = "";
$mensaje = "";
try {
$conexion = App::getConnection();
$imagenesRepository = new ImagenRepository();
$categoriasRepository = new CategoriaRepository();
$imagenes = $imagenesRepository->findAll();
$categorias = $categoriasRepository->findAll();
} catch (QueryException $queryException) {
$errores[] = $fileException->getMessage();
} catch (AppException $appException) {
$errores[] = $appException->getMessage();
}
require_once __DIR__ . '/../views/galeria.view.php';
