<?php

namespace dwes\app\repository;

use dwes\core\database\QueryBuilder;
use dwes\app\entity\Exposicion;

class ExposicionRepository extends QueryBuilder
{
    public function __construct(string $table = 'exposiciones', string $classEntity = Exposicion::class)
    {
        parent::__construct($table, Exposicion::class);
    }

    public function guarda(Exposicion $exposicion): void
    {
        $fn = function () use ($exposicion): void {
            $this->save($exposicion);
        };

        $this->executeTransaction($fn);
    }

    public function edit(Exposicion $exposicion): void
    {
        $this->executeTransaction(function () use ($exposicion) {
            $this->update($exposicion);
        });
    }

    public function deleteById(int $id)
    {
        return $this->borrar(["id" => $id]);
    }

    public function findByUsuario(int $usuario): array
    {
        return $this->findBy(['usuario' => $usuario]);
    }


    public function findActivas(): array
    {
        return $this->findBy(['activa' => 1]);
    }



    public function findInactivas(): array
    {
        return $this->findBy(['activa' => 0]);
    }
}
