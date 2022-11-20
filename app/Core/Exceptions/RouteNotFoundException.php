<?php

namespace App\Core\Exceptions;

class RouteNotFoundException extends Exception
{
    public function __construct()
    {
        $this->message = "Page not found";
        $this->code = 404;

        parent::__construct($this->message, $this->code);
    }
}