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
use dwes\app\exceptions\ValidationException;
use dwes\core\Response;
use dwes\core\helpers\FlashMessage;

class GaleriaController
{

    public function index()
    {
        try {
            $imagenesRepository = App::getRepository(ImagenRepository::class);
            $categoriasRepository = App::getRepository(CategoriaRepository::class);

            $imagenes = $imagenesRepository->findByUsuario(App::get('appUser')->getId());

            $categorias = $categoriasRepository->findAll();

            $errores = FlashMessage::get('errores', []);
            $mensaje = FlashMessage::get('mensaje');
            $titulo = FlashMessage::get('titulo');
            $descripcion = FlashMessage::get('descripcion');
            $categoriaSeleccionada = FlashMessage::get('categoriaSeleccionada');

            Response::renderView('galeria', 'layout', compact(
                'imagenes',
                'categorias',
                'errores',
                'titulo',
                'descripcion',
                'mensaje',
                'categoriaSeleccionada'
            ));
        } catch (QueryException $e) {
            $errores[] = $e->getMessage();
            Response::renderView('galeria', 'layout', compact('errores'));
        } catch (AppException $e) {
            $errores[] = $e->getMessage();
            Response::renderView('galeria', 'layout', compact('errores'));
        }
    }

    public function nueva()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                App::get('router')->redirect('galeria');
            }

            $titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
            $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
            $categoria = trim(htmlspecialchars($_POST['categoria'] ?? ''));

            FlashMessage::set('descripcion', $descripcion);
            FlashMessage::set('titulo', $titulo);
            if (empty($categoria)) {
                throw new ValidationException("No se ha recibido la categoría");
            }
            FlashMessage::set('categoriaSeleccionada', $categoria);


            $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
            $imagen = new File('imagen', $tiposAceptados);
            $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);

            $imagenGaleria = new Imagen($imagen->getFileName(), $descripcion, $categoria);
            $imagenesRepository = App::getRepository(ImagenRepository::class);
            /**@var ImagenRepository $imagenesRepository */
            $imagenesRepository->guarda($imagenGaleria);

            App::get('logger')->add("Se ha guardado una imagen: " . $imagenGaleria->getNombre());
            $mensaje = "Se ha guardado la imagen correctamente";

            FlashMessage::set('mensaje', $mensaje);

            FlashMessage::unset('descripcion');
            FlashMessage::unset('titulo');
            FlashMessage::unset('categoriaSeleccionada');
            
        } catch (ValidationException $validationException) {
            FlashMessage::set('errores', [$validationException->getMessage()]);
        } catch (FileException $fileException) {
            FlashMessage::set('errores', [$fileException->getMessage()]);
        } catch (CategoriaException $categoriaException) {
            FlashMessage::set('errores', [$categoriaException->getMessage()]);
        } catch (QueryException $QueryException) {
            FlashMessage::set('errores', [$QueryException->getMessage()]);
        } catch (AppException $AppException) {
            FlashMessage::set('errores', [$AppException->getMessage()]);
        }

        // Si hay errores, los mostramos en la vista
        if (!empty($errores)) {
            $imagenes = App::getRepository(ImagenRepository::class)->findAll();
            $categorias = App::getRepository(CategoriaRepository::class)->findAll();
            Response::renderView('galeria', 'layout', compact(
                'imagenes',
                'categorias',
                'errores',
                'titulo',
                'descripcion'
            ));
        } else {
            // Redirigimos para evitar reenvío al recargar
            App::get('router')->redirect('galeria');
        }
    }

    public function show($id)
    {
        $imagenesRepository = App::getRepository(ImagenRepository::class);
        $imagen = $imagenesRepository->find($id);
        Response::renderView(
            'imagen-show',
            'layout',
            compact('imagen', 'imagenesRepository')
        );
    }

    public function editar($id)
    {
        $imagenesRepository = App::getRepository(ImagenRepository::class);
        $imagen = $imagenesRepository->find($id);
        $categorias = App::getRepository(CategoriaRepository::class)->findAll();
        Response::renderView(
            'editar',
            'layout',
            compact('imagen', 'imagenesRepository', 'categorias')
        );
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            App::get('router')->redirect('galeria');
        }

        /** @var ImagenRepository $repo */
        $repo = App::getRepository(ImagenRepository::class);
        /** @var Imagen $imagen */
        $imagen = $repo->find((int)$id);

        if (!$imagen) {
            App::get('router')->redirect('galeria');
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoriaId = (int)($_POST['categoria'] ?? 0);

        // Si alguno crítico falta, no se actualiza
        if ($categoriaId > 0) {
            $catRepo = App::getRepository(CategoriaRepository::class);
            $imagen->setCategoria($catRepo->find($categoriaId));
        }

        if ($titulo !== '' && $titulo !== $imagen->getTitulo()) {
            $imagen->setTitulo($titulo);
        }

        if ($descripcion !== '' && $descripcion !== $imagen->getDescripcion()) {
            $imagen->setDescripcion($descripcion);
        }

        if (!empty($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            try {
                $tipos = ['image/jpeg', 'image/gif', 'image/png'];
                $file = new File('imagen', $tipos);
                $file->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);
                $imagen->setNombre($file->getFileName());
            } catch (\Exception $e) {
            }
        }
        $repo->edit($imagen);

        App::get('router')->redirect('galeria');
    }

    public function borrar($id)
    {
        $imagenesRepository = App::getRepository(ImagenRepository::class);
        $imagenesRepository->deleteById($id);
        App::get('router')->redirect('galeria');
    }
}
