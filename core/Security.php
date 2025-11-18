<?php

namespace dwes\core;

class Security
{

    public static function isUserGranted(string $role): bool
    {
        if ($role === 'ROLE_ANONYMOUS')
            return true;
        $usuario = App::get('appUser');
        if (is_null($usuario))
            return false;
        $valor_role = App::get('config')['security']['roles'][$role];
        $valor_role_user = App::get('config')['security']['roles'][$usuario->getRole()];
        return ($valor_role_user >= $valor_role);
    }
}
