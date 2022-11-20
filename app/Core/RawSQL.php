<?php

namespace App\Core;

class RawSQL
{
    public $sql = '';

    public function __construct($sql)
    {
        $this->sql = $sql;
    }
}