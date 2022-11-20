<?php

namespace App\Core\Exceptions;

class MethodNotAllowedException extends Exception
{
    public function __construct()
    {
        $this->message = "Method not allowed";
        $this->code = 405;

        parent::__construct($this->message, $this->code);
    }
}