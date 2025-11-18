<?php

namespace dwes\app\exceptions;

use dwes\app\exceptions\AppException;

class AuthenticationException extends AppException
{
    public function __construct(string $message = "", int $code = 403)
    {
        parent::__construct($message, $code);
    }
}
