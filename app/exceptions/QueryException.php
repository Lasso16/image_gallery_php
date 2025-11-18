<?php
namespace dwes\app\exceptions;
use dwes\app\exceptions\AppException;
Class QueryException extends AppException
{
    public function __construct(string $message = "", int $code = 500)
    {
        return parent::__construct($message, $code);
    }
}