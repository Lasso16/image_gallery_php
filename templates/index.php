<?php require_once __DIR__ . '/../src/entity/imagen.class.php';
require_once __DIR__ . '/../src/entity/Asociado.class.php';
require_once __DIR__ . '/../repository/ImagenRepository.php';
require_once __DIR__ . '/../repository/AsociadosRepository.php';

$repoImagen = new ImagenRepository();
$imagenesIndex = $repoImagen->findAll();

$repoAsociado = new AsociadosRepository();
$asociadosIndex = $repoAsociado->findAll();

require_once __DIR__ . '/views/index.view.php';
