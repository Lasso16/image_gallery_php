<?php
require_once __DIR__ . '/../src/database/QueryBuilder.class.php';
require_once __DIR__ . '/../src/entity/Imagen.class.php';

class ImagenRepository extends QueryBuilder
{
    public function __construct(string $table = 'imagenes', string $classEntity = 'Imagen')
    {
        parent::__construct($table, $classEntity);
    }

    /**
* @param Imagen $imagenGaleria
* @return Categoria
* @throws NotFoundException
* @throws QueryException
*/
public function getCategoria(Imagen $imagenGaleria): Categoria
{
$categoriaRepository = new CategoriaRepository();
return $categoriaRepository->find($imagenGaleria->getCategoria());
}
}
