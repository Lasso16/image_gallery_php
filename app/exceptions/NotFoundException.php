<?php
namespace dwes\app\exceptions;
use dwes\app\exceptions\AppException;
class NotFoundException extends AppException {
    public function __construct(string $message = "", int $code = 404)
    {
        return parent::__construct($message, $code);
    }
}