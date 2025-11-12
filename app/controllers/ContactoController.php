<?php

namespace dwes\app\controllers;

use dwes\core\Response;

class ContactoController
{
    public function index()
    {
        Response::renderView('contact', 'layout-with-footer');
    }

    public function enviar()
    {

    }
}