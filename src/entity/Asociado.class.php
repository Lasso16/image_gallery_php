<?php
require_once __DIR__ . '/IEntity.interface.php';

class Asociado implements IEntity
{
    private $id;
    /**
     *@var string
     */
    private $nombre;
    /**
     *@var string
     */
    private $logo;
    /**
     *@var string
     */
    private $descripcion;
    const RUTA_LOGOS_ASOCIADOS = '/public/images/asociados/';


    public function __construct()
    {
        $this->id = null;
        $this->nombre = "";
        $this->logo = "";
        $this->descripcion = "";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setId($id): Asociado
    {
        $this->id = $id;
        return $this;
    }

    public function setNombre($nombre): Asociado
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function setLogo($logo): Asociado
    {
        $this->logo = $logo;
        return $this;
    }

    public function setDescripcion($descripcion): Asociado
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getUrl(): string
    {
        return self::RUTA_LOGOS_ASOCIADOS . $this->logo;
    }

    function __tostring(): string
    {
        return $this->descripcion;
    }

    function toArray(): array {
        return [
            'nombre' => $this->nombre,
            'logo' => $this->logo,
            'descripcion' => $this->descripcion
        ];
    }
    
}
