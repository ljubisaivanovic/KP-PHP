<?php

namespace App\Core\Exceptions;

class UnauthorizedException extends Exception
{
    public function __construct()
    {
        $this->message = "Unauthorized";
        $this->code = 403;

        parent::__construct($this->message, $this->code);
    }
}