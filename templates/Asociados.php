<?php
require_once __DIR__ . "/../src/utils/File.class.php";
require_once __DIR__ . "/../src/entity/Asociado.class.php";
require_once __DIR__ . "/../src/database/Connection.class.php";
$errores = [];
$mensaje = "";
$nombre = "";
$descripcion = "";
$captchaInput = "";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = trim(htmlspecialchars($_POST['nombre']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));

        if (empty($nombre)) {
            $errores[] = "El nombre del asociado es obligatorio.";
        }
        if (isset($_POST['captcha']) && ($_POST['captcha'] != "")) {
            if ($_SESSION['captchaGenerado'] != $_POST['captcha']) {
                $mensaje = "¡Ha introducido un código de seguridad incorrecto! Inténtelo de nuevo.";
                $errores = [];
                $nombre = "";
                $descripcion = "";
            } else {
                if (empty($errores)) {
                    $tiposAceptados = ["image/jpg", "image/png", "image/gif"];

                    $logo = new File('logo', $tiposAceptados);
                    $logo->saveUploadFile(Asociado::RUTA_LOGOS_ASOCIADOS);

                    $asociado = new Asociado();
                    
                    $conexion = Connection::make();
                    $sql = "INSERT INTO asociados (nombre, logo, descripcion) VALUES (:nombre, :logo, :descripcion)";
                    $pdoStatement = $conexion->prepare($sql);
                    $parametros = [
                        ':nombre' => $nombre,
                        ':logo' => $logo->getFileName(),
                        ':descripcion' => $descripcion
                    ];
                    if ($pdoStatement->execute($parametros) === false)
                        $errores[] = "No se ha podido guardar el asociado en la base de datos";
                    else {
                        $descripcion = "";
                        $mensaje = "Se ha guardado el asociado correctamente";
                    }

                    $mensaje = "El asociado '{$asociado->getNombre()}' se ha registrado correctamente.";
                }
            }
        } else {
            $mensaje = "";
            $errores[] = "Introduzca el código de seguridad.";
            $nombre = "";
            $descripcion = "";
        }
    } catch (FileException $err) {
        $errores[] = $err->getMessage();
    } catch (Exception $err) {
        $errores[] = $err->getMessage();
    }
}
require_once __DIR__ . "/views/asociados.view.php";
