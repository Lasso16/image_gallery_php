<?php

namespace dwes\app\repository;
use dwes\app\entity\Categoria;
use dwes\core\database\QueryBuilder;

class CategoriaRepository extends QueryBuilder
{
    public function __construct(string $table = 'categorias', string $classEntity = Categoria::class)
    {
        parent::__construct($table, $classEntity);
    }

    /**
     * Summary of nuevaImagen
     * @param Categoria $categoria
     * @return void
     */
    public function nuevaImagen(Categoria $categoria) {
        $categoria->setNumImagenes($categoria->getNumImagenes() + 1);
        $this->update($categoria);
    }
}
