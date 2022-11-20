<?php

namespace App\Core\Routing;

class Route
{
    /**
     * Request method required for this route
     *
     * @var
     */
    public $method;

    /**
     * Route's uri
     *
     * @var
     */
    public $uri;

    /**
     * Check if route requires authentication
     *
     * @var
     */
    public $requireAuth = false;

    /**
     * Action to execute when the route is accessed
     *
     * @var array
     */
    public $action = [];

    /**
     * Name of the route
     *
     * @var null
     */
    public $name = null;

    /**
     * Route parameters
     *
     * @var null
     */
    public $parameters = null;

    /**
     * Route constructor.
     * @param $method
     * @param $uri
     * @param $requireAuth
     */
    public function __construct($method, $uri, $requireAuth = false)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->requireAuth = $requireAuth;
    }

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $action = explode('@', $action);

        $this->action = [
            'class' => $action[0],
            'method' => $action[1]
        ];

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasParameters() : bool
    {
        return ($this->parameters !== null) ? true : false;
    }

    /**
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
}