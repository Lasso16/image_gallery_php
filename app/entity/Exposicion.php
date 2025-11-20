<?php

namespace dwes\app\entity;

use dwes\app\entity\IEntity;

class Exposicion implements IEntity
{
    /**
     * Summary of id
     * @var int|null
     */
    private ?int $id = null;
    /**
     * Summary of nombre
     * @var string
     */
    private string $nombre;
    /**
     * Summary of descripcion
     * @var string
     */
    private string $descripcion;
    /**
     * Summary of fechaInicio
     * @var string
     */
    private string $fechaInicio;
    /**
     * Summary of fechaFin
     * @var string
     */
    private string $fechaFin;
    /**
     * Summary of activa
     * @var bool
     */
    private bool $activa;
    /**
     * Summary of usuario
     * @var int
     */
    private int $idUsuario;

    public function __construct(
        string $nombre = "",
        string $descripcion = "",
        string $fechaInicio = "",
        string $fechaFin = "",
        bool $activa = false,
        int $idUsuario = 0
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->activa = $activa;
        $this->idUsuario = $idUsuario;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getFechaInicio(): string
    {
        return $this->fechaInicio;
    }

    public function getFechaFin(): string
    {
        return $this->fechaFin;
    }

    public function isActiva(): bool
    {
        return $this->activa;
    }

    public function getidUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setFechaInicio(string $fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin(string $fechaFin): void
    {
        $this->fechaFin = $fechaFin;
    }

    public function setActiva(bool $activa): void
    {
        $this->activa = $activa;
    }

    public function setUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'activa' => $this->activa ? 1 : 0,
            'idUsuario' => $this->idUsuario
        ];
    }
}
