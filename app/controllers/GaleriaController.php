<?php

namespace dwes\app\controllers;

use dwes\core\App;
use dwes\app\repository\ImagenRepository;
use dwes\app\repository\CategoriaRepository;
use dwes\app\exceptions\FileException;
use dwes\app\exceptions\CategoriaException;
use dwes\app\exceptions\QueryException;
use dwes\app\exceptions\AppException;
use dwes\app\utils\File;
use dwes\app\entity\Imagen;

class GaleriaController
{
    public function index()
    {
        $errores = [];
        $titulo = "";
        $descripcion = "";
        $mensaje = "";

        try {
            $imagenesRepository = App::getRepository(ImagenRepository::class);
            $categoriasRepository = App::getRepository(CategoriaRepository::class);

            $imagenes = $imagenesRepository->findAll();
            $categorias = $categoriasRepository->findAll();

            \dwes\core\Response::renderView('galeria', 'layout', compact(
                'imagenes', 'categorias', 'errores', 'titulo', 'descripcion', 'mensaje'
            ));
        } catch (QueryException $e) {
            $errores[] = $e->getMessage();
            \dwes\core\Response::renderView('galeria', 'layout', compact('errores'));
        } catch (AppException $e) {
            $errores[] = $e->getMessage();
            \dwes\core\Response::renderView('galeria', 'layout', compact('errores'));
        }
    }

    public function nueva()
    {
        $errores = [];
        $mensaje = "";

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                App::get('router')->redirect('galeria');
            }

            $titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
            $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
            $categoria = trim(htmlspecialchars($_POST['categoria'] ?? ''));

            if (empty($categoria)) {
                throw new CategoriaException();
            }

            $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
            $imagen = new File('imagen', $tiposAceptados);
            $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);

            $imagenGaleria = new Imagen($imagen->getFileName(), $descripcion, $categoria);
            $imagenesRepository = App::getRepository(ImagenRepository::class);
            $imagenesRepository->guarda($imagenGaleria);

            App::get('logger')->add("Se ha guardado una imagen: " . $imagenGaleria->getNombre());
            $mensaje = "Se ha guardado la imagen correctamente";

        } catch (FileException $e) {
            $errores[] = $e->getMessage();
        } catch (CategoriaException) {
            $errores[] = "No se ha seleccionado una categoría válida";
        } catch (QueryException $e) {
            $errores[] = $e->getMessage();
        } catch (AppException $e) {
            $errores[] = $e->getMessage();
        }

        // Si hay errores, los mostramos en la vista
        if (!empty($errores)) {
            $imagenes = App::getRepository(ImagenRepository::class)->findAll();
            $categorias = App::getRepository(CategoriaRepository::class)->findAll();
            \dwes\core\Response::renderView('galeria', 'layout', compact(
                'imagenes', 'categorias', 'errores', 'titulo', 'descripcion'
            ));
        } else {
            // Redirigimos para evitar reenvío al recargar
            App::get('router')->redirect('galeria');
        }
    }
}