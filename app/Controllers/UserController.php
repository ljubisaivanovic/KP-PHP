<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Core\RawSQL;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Get all users method
     *
     * @return void
     */
    public function index()
    {
        $model = new User();
        $users = $model->get('posted', new RawSQL('NOW() - INTERVAL 10 DAY'), '>');

        echo json_encode($users);
    }
}