<?php

namespace dwes\app\controllers;

use dwes\core\App;
use dwes\app\repository\ImagenRepository;
use dwes\app\repository\AsociadosRepository;
use dwes\app\entity\Imagen;
use dwes\core\Response;
use dwes\app\exceptions\QueryException;

class PagesController
{
    /**
     * @throws QueryException
     */
    public function index()
    {
        $imagenGaleria = App::getRepository(ImagenRepository::class)->findAll();
        $asociadoLista = App::getRepository(AsociadosRepository::class)->findAll();
        Response::renderView(
            'index',
            'layout',
            compact('imagenGaleria', 'asociadoLista')
        );
    }
    public function about()
    {
        $imagenesClientes = [
            new Imagen('client1.jpg', 'MISS BELLA'),
            new Imagen('client2.jpg', 'DON PENO', 0),
            new Imagen('client3.jpg', 'SWEETY', 0),
            new Imagen('client4.jpg', 'LADY', 0)
        ];
        Response::renderView('about', 'layout', compact('imagenesClientes'));
    }
    public function blog()
    {
        Response::renderView('blog');
    }
    public function post()
    {
        Response::renderView('single_post');
    }
}
