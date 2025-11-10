<?php
require_once __DIR__ . '/../core/App.php';
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/entity/Imagen.class.php';
require_once __DIR__ . '/../repository/ImagenRepository.php';


$errores = [];
$titulo = "";
$descripcion = "";
$mensaje = "";
try {
    $config = require_once __DIR__ . '/../app/config.php';    
    $conexion = App::getConnection();
    $imagenesRepository = new ImagenRepository();
    $imagenes = $imagenesRepository->findAll();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
        $imagen = new File('imagen', $tiposAceptados);
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);
        $imagenGaleria = new Imagen();
        $imagenesRepository->save($imagenGaleria);
        $mensaje = "Se ha guardado la imagen correctamente";
        $imagenes = $imagenesRepository->findAll();
    }
} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $fileException->getMessage();
} catch (AppException $appException) {
    $errores[] = $appException->getMessage();
}
require_once __DIR__ . '/views/galeria.view.php';
