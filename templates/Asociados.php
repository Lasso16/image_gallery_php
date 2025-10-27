<?php
require_once __DIR__ . "/../src/utils/File.class.php";
require_once __DIR__ . "/../src/entity/Asociado.class.php";
$errores = [];
$mensaje = "";
$nombre = "";
$descripcion = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = trim(htmlspecialchars($_POST['nombre']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));

        if (empty($nombre)) {
            $errores[] = "El nombre del asociado es obligatorio.";
        }

        if (empty($errores)) {
            $tiposAceptados = ["image/jpg", "image/png", "image/gif"];

            $logo = new File('logo', $tiposAceptados);
            $logo->saveUploadFile(Asociado::RUTA_LOGOS_ASOCIADOS);

            $asociado = new Asociado($nombre, $logo->getFileName(), $descripcion);

            $mensaje = "El asociado '{$asociado->getNombre()}' se ha registrado correctamente.";
        }
    } catch (FileException $err) {
        $errores[] = $err->getMessage();
    } catch (Exception $err) {
        $errores[] = $err->getMessage();
    }
}
require_once __DIR__ . "/views/asociados.view.php";
