<?php

namespace App\Core;

class Model extends ORM
{
    protected $connection = null;
    protected $table = '';
    protected $fillable = [];

    public function __construct()
    {
        $this->connection = Database::getInstance();
    }
}