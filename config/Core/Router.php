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
        $this->method = requestMethod();
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

            $expected_uri = $this->explodeUri($route['uri']);
            $received_uri = $this->explodeUri($this->uri);

            if ($this->isDynamicParam($expected_uri, $received_uri)) {
                $route['uri'] = $this->interpretDynamicParam($expected_uri, $received_uri);
            }

            if ($this->matchingUri($route, $this->method, $this->query, $this->uri)) {
                $controller = new $route['controller'][0]();
                $function = $route['controller'][1];
                $request = returnRequestJson();
//                return $controller->{$function}($received_uri['id'], $request);
                if (is_null($received_uri['id']) && !is_null($request)) {
                    return $controller->{$function}($request);
                }
                if (!is_null($received_uri['id']) && is_null($request)){
                    return $controller->{$function}($request);
                }
                if (!is_null($received_uri['id']) && !is_null($request)){
                    return $controller->{$function}($received_uri['id'], $request);
                }
                //return $result;
            }
        }
        //abort();
    }
    function interpretDynamicParam($expected_uri, $received_uri): string
    {
        $expected_uri['id'] &= $received_uri['id'];
        $checking_array = array_filter([$expected_uri['path'], $received_uri['id'], $expected_uri['filter']], function ($value) {
            return $value !== null && $value !== '';
        });
        return '/'.implode('/', $checking_array);
    }

    function isDynamicParam($expected_uri, $received_uri): bool
    {
        return $expected_uri['path'] === $received_uri['path']
            && str_contains($expected_uri['id'], '{')
            && is_numeric($received_uri['id']);

    }
    function explodeUri($uri): array
    {
        $params = explode('/', substr($uri, 1));
        $path = $params[0] ?? null;
        $id = $params[1] ?? null;
        $filter = $params[2] ?? null;
        return (compact('path', 'id', 'filter'));
    }

    function matchingUri($route, $method, $query, $uri): bool
    {
        return $route['method'] === strtoupper($method)
            && $route['uri'] === $uri && empty($query);
    }

}

