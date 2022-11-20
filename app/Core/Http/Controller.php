<?php

namespace App\Core\Http;

use App\Core\Authentication;

abstract class Controller
{
    /**
     * Instance of Request class
     *
     * @var Request
     */
    public $request;

    /**
     * Instance of Authentication class
     *
     * @var Authentication
     */
    public $auth;

    public function __construct(Request $request, Authentication $auth)
    {
        $this->request = $request;
        $this->auth = $auth;
    }
}