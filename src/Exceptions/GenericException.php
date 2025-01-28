<?php

namespace InovantiBank\Toolkit\Exceptions;

use Exception;

class GenericException extends Exception
{
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
