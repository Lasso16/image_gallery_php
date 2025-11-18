<?php 
namespace dwes\app\repository;

use dwes\app\entity\Usuario;
use dwes\core\database\QueryBuilder;
class UsuarioRepository extends QueryBuilder{
    
    public function __construct(string $table='usuarios', string $classEntity=Usuario::class)
    {
        parent::__construct($table, $classEntity);
    }
}