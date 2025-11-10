<?php
require_once __DIR__ . '/../core/App.php';
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/entity/Imagen.class.php';
require_once __DIR__ . '/../repository/ImagenRepository.php';
require_once __DIR__ . '/../repository/CategoriaRepository.php';


$errores = [];
$titulo = "";
$descripcion = "";
$mensaje = "";
try {
    $config = require_once __DIR__ . '/../app/config.php';
    $conexion = App::getConnection();
    $imagenesRepository = new ImagenRepository();
    $imagenes = $imagenesRepository->findAll();

    $categoriaRepository = new CategoriaRepository();
    $categorias = $categoriaRepository->findAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $categoria = trim(htmlspecialchars($_POST['categoria']));
        if (empty($categoria))
            throw new CategoriaException;
        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
        $imagen = new File('imagen', $tiposAceptados);
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);
        $imagenGaleria = new Imagen($imagen->getFileName(),$descripcion, $categoria);
        $imagenesRepository->guarda($imagenGaleria);
        $mensaje = "Se ha guardado la imagen correctamente";
        $imagenes = $imagenesRepository->findAll();
    }
} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (CategoriaException) {
    $errores[] = "No se ha seleccionado una categoría válida";
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (AppException $appException) {
    $errores[] = $appException->getMessage();
}
require_once __DIR__ . '/views/galeria.view.php';
