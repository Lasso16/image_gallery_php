<?php
class Utils
{
    static function esOpcionMenuActiva($opcion): bool
    {
        $actual = explode('/', $_SERVER['REQUEST_URI']);
        $actual = '/' . $actual[count($actual) - 1];
        return  $actual == $opcion;
    }

    public static function extraeElementosAleatorios($lista, $cantidad): ?array
    {
        if ($cantidad < 1 || sizeof($lista) == 0) return null;
        else {
            shuffle($lista);
            $listaNueva = array_chunk($lista, $cantidad);
            return $listaNueva[0];
        }
    }
}
