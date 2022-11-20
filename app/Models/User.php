<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'user';

    protected $fillable = [
        'email', 'password', 'posted',
    ];
}