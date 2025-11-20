<?php

namespace dwes\app\repository;

use dwes\core\database\QueryBuilder;
use dwes\app\entity\ImagenExposicion;

class ImagenExposicionRepository extends QueryBuilder
{
    public function __construct(
        string $table = 'imagen_exposicion',
        string $classEntity = ImagenExposicion::class
    ) {
        parent::__construct($table, ImagenExposicion::class);
    }

    public function add(int $idImagen, int $idExposicion): void
    {
        $relacion = new ImagenExposicion($idImagen, $idExposicion);
        $this->executeTransaction(function () use ($relacion) {
            $this->save($relacion);
        });
    }

    public function deleteRelation(int $idImagen, int $idExposicion): void
    {
        $this->borrar([
            'id_imagen'     => $idImagen,
            'id_exposicion' => $idExposicion
        ]);
    }
}
