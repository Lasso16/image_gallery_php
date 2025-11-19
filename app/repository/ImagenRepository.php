<?php

namespace dwes\app\repository;

use dwes\app\entity\Imagen;
use dwes\app\entity\Categoria;
use dwes\app\repository\CategoriaRepository;
use dwes\app\exceptions\QueryException;
use dwes\core\database\QueryBuilder;
use dwes\app\exceptions\NotFoundException;

class ImagenRepository extends QueryBuilder
{
    public function __construct(string $table = 'imagenes', string $classEntity = Imagen::class)
    {
        parent::__construct($table, Imagen::class);
    }

    /**
     * @param Imagen $imagenGaleria
     * @return Categoria
     * @throws NotFoundException
     * @throws QueryException
     */
    public function getCategoria(Imagen $imagenGaleria): Categoria
    {
        $cat = $imagenGaleria->getCategoria();
        if ($cat instanceof Categoria) {
            return $cat;
        }

        $categoriaRepository = new CategoriaRepository();
        return $categoriaRepository->find((int)$cat);
    }

    /**
     * 
     * @param Imagen $imagenGaleria
     * @return void
     */
    public function guarda(Imagen $imagenGaleria): void
    {
        $fnGuardarImagen = function () use ($imagenGaleria) {
            $categoria = $this->getCategoria($imagenGaleria);
            $categoriaRepository = new CategoriaRepository();
            $categoriaRepository->nuevaImagen($categoria);

            $this->save($imagenGaleria);
        };

        $this->executeTransaction($fnGuardarImagen);
    }

    public function findByUsuario(int $idUsuario) {
        return $this->findBy(["idUsuario"  => $idUsuario]);
    }

    public function deleteById(int $id) {
        return $this->borrar(["id" => $id]);
    }

    public function edit(Imagen $imagen) {
        $this->update($imagen); 
    }
}