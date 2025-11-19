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
            /**
             * @var ImagenRepository $imagenesRepository
             */
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            App::get('router')->redirect('galeria');
        }

        $titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
        $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
        $categoria = trim(htmlspecialchars($_POST['categoria'] ?? ''));

        FlashMessage::set('titulo', $titulo);
        FlashMessage::set('descripcion', $descripcion);
        FlashMessage::set('categoriaSeleccionada', $categoria);

        $errores = [];
        $nombreImagenSubida = '';

        if (isset($_FILES['imagen']) && ($_FILES['imagen']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            try {
                $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
                $imagen = new File('imagen', $tiposAceptados);
                $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);
                $nombreImagenSubida = $imagen->getFileName();
                FlashMessage::set('imagenSubida', $nombreImagenSubida);
            } catch (FileException $fileException) {
                $errores[] = $fileException->getMessage();
            }
        }
        if ($titulo === '') {
            $errores[] = 'El título es obligatorio';
        }
        if ($descripcion === '') {
            $errores[] = 'La descripción es obligatoria';
        }
        if ($categoria === '') {
            $errores[] = 'No se ha recibido la categoría';
        }

        if (!empty($errores)) {
            FlashMessage::set('errores', $errores);
            App::get('router')->redirect('galeria');
        }

        $nombreFichero = $nombreImagenSubida;
        if ($nombreFichero === '') {
            $nombreFichero = FlashMessage::get('imagenSubida', '');
        }
        if ($nombreFichero === '') {
            FlashMessage::set('errores', ['Debe seleccionar una imagen']);
            App::get('router')->redirect('galeria');
        }

        try {
            $imagenGaleria = new Imagen($nombreFichero, $descripcion, $titulo, $categoria);
            $imagenGaleria->setIdUsuario(App::get('appUser')->getId());
            /** @var ImagenRepository $imagenesRepository */
            $imagenesRepository = App::getRepository(ImagenRepository::class);
            $imagenesRepository->guarda($imagenGaleria);

            App::get('logger')->add('Se ha guardado una imagen: ' . $imagenGaleria->getNombre());
            FlashMessage::set('mensaje', 'Se ha guardado la imagen correctamente');

            FlashMessage::unset('titulo');
            FlashMessage::unset('descripcion');
            FlashMessage::unset('categoriaSeleccionada');
        } catch (FileException $fileException) {
            FlashMessage::unset('imagenSubida');
            FlashMessage::set('errores', [$fileException->getMessage()]);
        } catch (CategoriaException $categoriaException) {
            FlashMessage::set('errores', [$categoriaException->getMessage()]);
        } catch (QueryException $queryException) {
            FlashMessage::set('errores', [$queryException->getMessage()]);
        } catch (AppException $appException) {
            FlashMessage::set('errores', [$appException->getMessage()]);
        }

        App::get('router')->redirect('galeria');
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
        /**
         * @var ImagenRepository $imagenesRepository
         */
        $imagenesRepository = App::getRepository(ImagenRepository::class);
        $imagenesRepository->deleteById($id);
        App::get('router')->redirect('galeria');
    }
}
