<?php


namespace dwes\app\entity\Asociado;
use dwes\app\repository\AsociadosRepository;
use dwes\app\utils\File;
use dwes\app\entity\Asociado;
use Exception;

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

        if (isset($_POST['captcha']) && $_POST['captcha'] !== "") {
            if ($_SESSION['captchaGenerado'] != $_POST['captcha']) {
                $mensaje = "Código de seguridad incorrecto. Inténtelo de nuevo.";
                $errores = [];
                $nombre = "";
                $descripcion = "";
            } else {
                if (empty($errores)) {
                    $tiposAceptados = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
                    $logo = new File('logo', $tiposAceptados);
                    $logo->saveUploadFile(Asociado::RUTA_LOGOS_ASOCIADOS);

                    $asociado = new Asociado();
                    $asociado->setNombre($nombre)
                        ->setLogo($logo->getFileName())
                        ->setDescripcion($descripcion);

                    $repo = new AsociadosRepository();
                    $repo->save($asociado);

                    $mensaje = "El asociado '{$asociado->getNombre()}' se ha guardado correctamente.";
                    $nombre = "";
                    $descripcion = "";
                }
            }
        } else {
            $errores[] = "Debe introducir el código de seguridad (captcha).";
        }
    } catch (Exception $e) {
        $errores[] = $e->getMessage();
    }
}

$repo = new AsociadosRepository();
$asociadosIndex = $repo->findAll();

require_once __DIR__ . "/../views/asociados.view.php";
