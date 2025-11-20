<?php

namespace dwes\app\controllers;

use dwes\core\App;
use dwes\core\Response;
use dwes\app\entity\Exposicion;
use dwes\app\exceptions\QueryException;
use dwes\core\helpers\FlashMessage;
use dwes\app\exceptions\AppException;
use dwes\app\exceptions\ValidationException;
use dwes\app\repository\ExposicionRepository;
use dwes\app\repository\ImagenExposicionRepository;
use dwes\app\repository\ImagenRepository;

class ExposicionesController
{
    public function index()
    {
        $expoRepository = App::getRepository(ExposicionRepository::class);
        $imagenExpoRepository = App::getRepository(ImagenExposicionRepository::class);
    

        $imagenRepository = App::getRepository(ImagenRepository::class);
        
        $exposiciones = [];
        $imgExpuestas = [];
        try {
            $exposiciones = $expoRepository->findAll();
            $imgExpuestas = $imagenExpoRepository->findAll();
    
        } catch (QueryException $e) {
            FlashMessage::set('errores', [$e->getMessage()]);
        }
        $errores = FlashMessage::get('errores', []);
        $mensaje = FlashMessage::get('mensaje', '');
        Response::renderView('exposiciones', 'layout', compact('exposiciones', 'errores', 'mensaje', 'imgExpuestas', 'imagenRepository'));
    }
    public function crear()
    {
        $errores = FlashMessage::get('errores', []);
        $mensaje = FlashMessage::get('mensaje', '');
        $nombre = FlashMessage::get('nombre', '');
        $descripcion = FlashMessage::get('descripcion', '');
        $fechaInicio = FlashMessage::get('fechaInicio', '');
        $fechaFin = FlashMessage::get('fechaFin', '');
        $activa = FlashMessage::get('activa', 0);

        Response::renderView('exposicionesForm', 'layout', compact(
            'errores', 'mensaje', 'nombre', 'descripcion', 'fechaInicio', 'fechaFin', 'activa'
        ));
    }

    public function nueva()
    {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            App::get('router')->redirect('exposiciones/nueva');
        }

        $errores = [];
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fechaInicio = trim($_POST['fechaInicio'] ?? '');
        $fechaFin = trim($_POST['fechaFin'] ?? '');
        $activa = isset($_POST['activa']) ? 1 : 0;

        FlashMessage::set('nombre', $nombre);
        FlashMessage::set('descripcion', $descripcion);
        FlashMessage::set('fechaInicio', $fechaInicio);
        FlashMessage::set('fechaFin', $fechaFin);
        FlashMessage::set('activa', $activa);

        if ($nombre === '') {
            $errores[] = 'El nombre es obligatorio';
        }
        if ($descripcion === '') {
            $errores[] = 'La descripción es obligatoria';
        }
        if ($fechaInicio === '') {
            $errores[] = 'La fecha de inicio es obligatoria';
        }
        if ($fechaFin === '') {
            $errores[] = 'La fecha de fin es obligatoria';
        }
        if ($fechaInicio !== '' && $fechaFin !== '' && $fechaInicio > $fechaFin) {
            $errores[] = 'La fecha de inicio no puede ser posterior a la fecha de fin';
        }

        

        try {
            $usuarioId = (int)(App::get('appUser')->getId() ?? 0);
            $exposicion = new Exposicion(
                $nombre,
                $descripcion,
                $fechaInicio,
                $fechaFin,
                (bool)$activa,
                $usuarioId
            );
            /** @var ExposicionRepository $expoRepository */
            $expoRepository = App::getRepository(ExposicionRepository::class);
            $expoRepository->guarda($exposicion);

            FlashMessage::set('mensaje', 'Exposición creada correctamente');
            FlashMessage::unset('nombre');
            FlashMessage::unset('descripcion');
            FlashMessage::unset('fechaInicio');
            FlashMessage::unset('fechaFin');
            FlashMessage::unset('activa');

            App::get('router')->redirect('exposiciones/nueva');
        } catch (QueryException $queryException) {            
            FlashMessage::set('errores', [$queryException->getMessage()]);
        } catch (AppException $appException) {
            FlashMessage::set('errores', [$appException->getMessage()]);
        }
        
        if (!empty($errores)) {
            FlashMessage::set('errores', $errores);
            return Response::renderView('exposicionesForm', 'layout', compact(
                'errores', 'nombre', 'descripcion', 'fechaInicio', 'fechaFin', 'activa'
            ));
        } else {
            App::get('router')->redirect('exposiciones');
        }
    }
}