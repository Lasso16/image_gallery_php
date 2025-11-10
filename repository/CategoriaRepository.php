<?php
require_once __DIR__ . '/../src/database/QueryBuilder.class.php';
require_once __DIR__ . '/../src/entity/Categoria.class.php';

class CategoriaRepository extends QueryBuilder
{
    public function __construct(string $table = 'categorias', string $classEntity = 'Categoria')
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
