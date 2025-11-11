<?php
namespace dwes\app\entity;
use dwes\app\entity\Asociado;
use dwes\app\repository\ImagenRepository;
use dwes\app\repository\AsociadosRepository;

$repoImagen = new ImagenRepository();
$imagenesIndex = $repoImagen->findAll();

$repoAsociado = new AsociadosRepository();
$asociadosIndex = $repoAsociado->findAll();

require_once __DIR__ . '/../views/index.view.php';
