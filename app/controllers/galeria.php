<?php
require_once __DIR__ . '/../../core/App.php';
require_once __DIR__ . '/../../src/utils/File.class.php';
require_once __DIR__ . '/../../src/entity/Imagen.class.php';
require_once __DIR__ . '/../../repository/ImagenRepository.php';
require_once __DIR__ . '/../../repository/CategoriaRepository.php';


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
