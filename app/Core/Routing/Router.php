<?php

namespace App\Core\Routing;

use App\Core\Authentication;
use App\Core\Exceptions\Exception;
use App\Core\Exceptions\UnauthorizedException;
use App\Core\Http\Request;

class Router
{
    public $routeCollection;
    public $uri;

    protected $request;
    protected $auth;

    public function __construct()
    {
        $this->routeCollection = new RouteCollection();
    }

    /**
     * @return $this
     * @throws \App\Core\Exceptions\RouteNotFoundException
     * @throws \App\Core\Exceptions\MethodNotAllowedException
     * @throws \App\Core\Exceptions\UnauthorizedException
     */
    public function init()
    {
        $this->request = new Request();
        $this->auth = new Authentication();

        try {
            $route = $this->routeCollection->find($this->request->method, $this->request->uri);

            if ($route !== null)
            {
                if ($route->requireAuth) {
                    if ($this->auth->check()) {
                        $this->executeRouteAction($route);
                    } else {
                        throw new UnauthorizedException();
                    }
                }

                $this->executeRouteAction($route);
            }
        }
        catch(Exception $e) {
            $e->print(true);
            return null;
        }

        return $this;
    }

    /**
     * @param $method
     * @param $path
     * @param $action
     * @param bool $requireAuth
     * @return $this
     */
    public function defineRoute($method, $path, $action, $requireAuth = false)
    {
        $route = new Route($method, $path, $requireAuth);
        $route->setAction($action);

        $this->routeCollection->add($route);

        return $this;
    }

    /**
     * @param Route $route
     * @return mixed
     */
    public function executeRouteAction(Route $route)
    {
        $instance = new $route->action['class']($this->request, $this->auth);
        return $instance->{$route->action['method']}(...$route->parameters);
    }
}