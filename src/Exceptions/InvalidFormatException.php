<?php

namespace InovantiBank\Toolkit\Exceptions;

use Exception;

class InvalidFormatException extends Exception
{
    public function __construct(string $message = 'Formato inválido.', int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
