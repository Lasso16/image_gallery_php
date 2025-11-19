<?php

namespace dwes\app\controllers;

use dwes\core\App;
use dwes\core\Response;
use dwes\core\helpers\FlashMessage;
use dwes\app\repository\ExposicionRepository;
use dwes\app\repository\ImagenExposicionRepository;
use dwes\app\exceptions\QueryException;
use dwes\app\exceptions\AppException;

class ImagenExposicionController
{
    public function seleccionar(int $idImagen)
    {
        
        try {
            /** @var ExposicionRepository $repoExpo */
            $repoExpo = App::getRepository(ExposicionRepository::class);
            $exposiciones = $repoExpo->findActivas();

            $errores = FlashMessage::get('errores', []);
            $mensaje = FlashMessage::get('mensaje', '');

            Response::renderView(
                'exposicionesSelect',
                'layout',
                compact('idImagen', 'exposiciones', 'errores', 'mensaje')
            );
        } catch (QueryException $e) {
            FlashMessage::set('errores', [$e->getMessage()]);
            App::get('router')->redirect('galeria');
        }
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            App::get('router')->redirect('galeria');
        }

        $idImagen = isset($_POST['id_imagen']) ? (int)$_POST['id_imagen'] : 0;
        $idExposicion = isset($_POST['id_exposicion']) ? (int)$_POST['id_exposicion'] : 0;

        if ($idImagen <= 0 || $idExposicion <= 0) {
            FlashMessage::set('errores', ['Datos incompletos para añadir la imagen a la exposición']);
            App::get('router')->redirect('galeria');
        }

        try {
            /** @var ImagenExposicionRepository $repoImgExpo */
            $repoImgExpo = App::getRepository(ImagenExposicionRepository::class);

            $existe = $repoImgExpo->findOneBy([
                'id_imagen'     => $idImagen,
                'id_exposicion' => $idExposicion
            ]);

            if ($existe !== null) {
                FlashMessage::set('errores', ['Esta imagen ya está añadida a esa exposición.']);
                App::get('router')->redirect("exposicion/anadirimagen/$idImagen");
            }
            $repoImgExpo->add($idImagen, $idExposicion);

            FlashMessage::set('mensaje', 'Imagen añadida correctamente a la exposición.');
            App::get('router')->redirect('exposiciones');

        } catch (QueryException|AppException $e) {
            FlashMessage::set('errores', [$e->getMessage()]);
            App::get('router')->redirect("exposicion/anadirimagen/$idImagen");
        }
    }
}
