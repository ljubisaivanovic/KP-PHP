<?php

namespace App\Core;

class Authentication
{
    /**
     * Session instance
     *
     * @var Session|null
     */
    protected $session = null;

    /**
     * Authentication constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * Checks if a user is logged in
     *
     * @return bool
     */
    public function check()
    {
        return $this->session->has('user');
    }

    public function user()
    {
        return $this->check() ? $this->session->get('user') : null;
    }

    /**
     * Logs in a user
     *
     * @param $user
     */
    public function login($user)
    {
        $this->session->set('user', $user);
    }

    /**
     * Logs out the user
     */
    public function logout()
    {
        $this->session->delete('user');
    }
}