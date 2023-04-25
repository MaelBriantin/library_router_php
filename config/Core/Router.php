<?php


namespace Core;

use Traits\RequestFormat;
use Traits\ReturnJson;

class Router
{
    use RequestFormat;
    use ReturnJson;

    protected $routes = [];
    protected $method;
    protected $uri;
    protected $query;
    public function __construct()
    {
        $this->method = request_method();
        $this->uri = uri('path');
        $this->query = uri('query');
    }

    public function add($method, $uri, $controller)
    {
        $this->routes[] = compact('method', 'uri', 'controller');
    }

    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->add('PUT', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        $this->add('PATCH', $uri, $controller);
    }

    public function init()
    {
        foreach ($this->routes as $route) {

            $expected_uri = $this->explode_uri($route['uri']);
            $received_uri = $this->explode_uri($this->uri);

            if (($expected_uri['path'] === $received_uri['path'])
                && str_contains($expected_uri['id'], '{')
                && is_numeric($received_uri['id'])) {

                $expected_uri['id'] &= $received_uri['id'];
                $checking_array = array_filter([$expected_uri['path'], $received_uri['id'], $expected_uri['filter']], function ($value) {
                    return $value !== null && $value !== '';
                });
                $route['uri'] = '/'.implode('/', $checking_array);

            }

            if ($this->matching_uri($route, $this->method, $this->query, $this->uri)) {

                $controller = new $route['controller'][0]();
                $function = $route['controller'][1];
                return $controller->{$function}($received_uri['id']);

            }
        }
        abort(404);
    }

    public function explode_uri($uri) {
        $params = explode('/', substr($uri, 1));
        $path = $params[0] ?? null;
        $id = $params[1] ?? null;
        $filter = $params[2] ?? null;
        return (compact('path', 'id', 'filter'));
    }

    public function matching_uri($route, $method, $query, $uri) {
        $match = false;
        if ($route['method'] === strtoupper($method)
            && $route['uri'] === $uri && empty($query)) {
            $match = true;
        };
        return $match;
    }
}

