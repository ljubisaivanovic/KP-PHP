<?php

namespace App\Models;

use App\Core\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';

    protected $fillable = [
        'user_id', 'action', 'log_time'
    ];
}