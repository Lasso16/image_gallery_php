<?php

namespace dwes\app\controllers;

use dwes\core\App;
use dwes\app\repository\AsociadosRepository;
use dwes\app\entity\Asociado;
use dwes\app\exceptions\QueryException;
use dwes\core\Response;
use dwes\app\utils\File;
use dwes\app\exceptions\FileException;
use Exception;
class AsociadosController
{
    public function index()
    {
        $errores = [];
        try {
            $asociados = App::getRepository(AsociadosRepository::class)->findAll();
            Response::renderView('asociados', 'layout', compact('asociados', 'errores'));
        } catch (QueryException $e) {
            $errores[] = $e->getMessage();
            Response::renderView('asociados', 'layout', compact('errores'));
        }
    }

    public function nuevo()
    {
        session_start();

        $errores = [];
        $mensaje = "";
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $captchaInput = $_POST['captcha'] ?? '';

        try {
            if (empty($nombre)) {
                $errores[] = "El nombre del asociado es obligatorio.";
            }
            if (empty($descripcion)) {
                $errores[] = "La descripción es obligatoria.";
            }

            if (empty($captchaInput) || !isset($_SESSION['captchaGenerado']) || $_SESSION['captchaGenerado'] !== $captchaInput) {
                $errores[] = "El código de seguridad (captcha) no es correcto.";
            }

            if (empty($errores)) {
                $tiposAceptados = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
                $logo = new File('logo', $tiposAceptados);

                $logo->saveUploadFile(__DIR__ . '/../../public/images/asociados/');

                $asociado = (new Asociado())
                    ->setNombre($nombre)
                    ->setLogo($logo->getFileName())
                    ->setDescripcion($descripcion);

                $repo = App::getRepository(AsociadosRepository::class);
                $repo->save($asociado);

                $mensaje = "El asociado '{$asociado->getNombre()}' se ha registrado correctamente.";

                $nombre = "";
                $descripcion = "";
            }
        } catch (FileException $e) {
            $errores[] = "Error al subir el archivo: " . $e->getMessage();
        } catch (QueryException $e) {
            $errores[] = "Error al guardar el asociado: " . $e->getMessage();
        } catch (Exception $e) {
            $errores[] = "Se ha producido un error inesperado: " . $e->getMessage();
        }

        try {
            $repo = App::getRepository(AsociadosRepository::class);
            $asociados = $repo->findAll();
        } catch (QueryException $e) {
            $asociados = [];
        }

        Response::renderView('asociados', 'layout', compact('errores', 'mensaje', 'nombre', 'descripcion', 'asociados'));
    }
}