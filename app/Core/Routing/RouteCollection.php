<?php

namespace App\Core\Routing;

use App\Core\Exceptions\Exception;
use App\Core\Exceptions\MethodNotAllowedException;
use App\Core\Exceptions\RouteNotFoundException;

class RouteCollection
{
    /**
     * @var array
     */
    public $routes = [];

    /**
     * @param $method
     * @param $uri
     * @return mixed|null
     */
    public function find($method, $uri)
    {
        $found = false;

        foreach ($this->routes as $route)
        {
            $regex_uri = preg_replace('/([{][a-zA-Z]*[}])/i', '(\w+)', $route->uri);
            $pattern = '/^' . str_replace('/', '\/', $regex_uri) . '$/';

            if (preg_match($pattern, $uri, $parameters))
            {
                $found = true;
                array_shift($parameters);

                if ($route->method === $method)
                {
                    $route->setParameters($parameters);
                    return $route;
                }
                else
                {
                    continue;
                }
            }
        }

        if ($found) {
            throw new MethodNotAllowedException();
        } else {
            throw new RouteNotFoundException();
        }
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function add(Route $route)
    {
        array_push($this->routes, $route);

        return $this;
    }
}