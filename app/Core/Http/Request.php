<?php

namespace App\Core\Http;

class Request
{
    /**
     * Request method
     *
     * @var string
     */
    public $method;

    /**
     * Requested uri
     *
     * @var string
     */
    public $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $this->formatURI();
    }

    /**
     * Formats URI
     *
     * @return string
     */
    private function formatURI()
    {
        $_url = isset($_GET['_url']) ? $_GET['_url'] : '/';

        if (substr($_url, 0, strlen('/')) !== '/')
            $_url = '/'.$_url;

        return $_url;
    }

    /**
     * Returns specific GET request parameter
     *
     * @param $key
     * @return null
     */
    public function get($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Returns specific POST request parameter
     *
     * @param $key
     * @return null
     */
    public function post($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Returns all request parameters
     *
     * @return mixed
     */
    public function all()
    {
        return !empty($_REQUEST) ? $_REQUEST : null;
    }
}