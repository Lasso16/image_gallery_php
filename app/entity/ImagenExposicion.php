<?php

namespace dwes\app\entity;

class ImagenExposicion implements IEntity
{
    private int $id_imagen;
    private int $id_exposicion;

    public function __construct(int $idImagen = 0, int $idExposicion = 0)
    {
        $this->id_imagen = $idImagen;
        $this->id_exposicion = $idExposicion;
    }

    public function getIdImagen(): int
    {
        return $this->id_imagen;
    }

    public function getIdExposicion(): int
    {
        return $this->id_exposicion;
    }

    public function toArray(): array
    {
        return [
            'id_imagen'     => $this->id_imagen,
            'id_exposicion' => $this->id_exposicion,
        ];
    }
}
