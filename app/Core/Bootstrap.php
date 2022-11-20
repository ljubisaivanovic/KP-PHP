<?php

namespace App\Core;

use App\Core\Routing\Router;

class Bootstrap
{
    /**
     * Router instance
     *
     * @var Router
     */
    public $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Sets database connection parameters
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setDatabaseParameter($key, $value)
    {
        define('DATABASE_'.$key, $value);

        return $this;
    }

    /**
     * Sets root directory of the project
     *
     * @param $directory
     * @return $this
     */
    public function setRootDirectory($directory)
    {
        define('ROOT_DIR', $directory);

        return $this;
    }

    /**
     * Initializes the application
     *
     * @return $this
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\RouteNotFoundException
     * @throws Exceptions\UnauthorizedException
     */
    public function boot()
    {
        $this->router->init();

        return $this;
    }
}