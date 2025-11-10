<?php

class Categoria implements IEntity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var int
     */
    private $numImagenes;

    public function __construct($nombre = "", $numImagenes = 0)
    {
        $this->id = null;
        $this->nombre = $nombre;
        $this->numImagenes = $numImagenes;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getNumImagenes()
    {
        return $this->numImagenes;
    }


    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setNumImagenes($numImagenes): void
    {
        $this->numImagenes = $numImagenes;
    }


    public function toArray(): array
    {

        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'numImagenes' => $this->getNumImagenes()
        ];
    }
}
