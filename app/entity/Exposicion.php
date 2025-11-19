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
    private int $usuario;

    public function __construct(
        string $nombre = "",
        string $descripcion = "",
        string $fechaInicio = "",
        string $fechaFin = "",
        bool $activa = false,
        int $usuario = 0
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->activa = $activa;
        $this->usuario = $usuario;
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

    public function getActiva(): bool
    {
        return $this->activa;
    }

    public function getUsuario(): int
    {
        return $this->usuario;
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

    public function setUsuario(int $usuario): void
    {
        $this->usuario = $usuario;
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
            'usuario' => $this->usuario
        ];
    }
}
