<?php namespace SimplexFraam;

class Router
{
    /**
     * @var \AltoRouter
     */
    public static $altorouter = null;

    /**
     * @return \AltoRouter
     */
    public static function getInstance(){
        if(!self::$altorouter){
            self::$altorouter = new \AltoRouter();
        }
        return self::$altorouter;
    }

    /**
     * Map a route to a target
     *
     * @param string $method One of 5 HTTP Methods, or a pipe-separated list of multiple HTTP Methods (GET|POST|PATCH|PUT|DELETE)
     * @param Route $route The route regex, custom regex must start with an @. You can use multiple pre-set regex filters, like [i:id]
     * @param mixed $target The target where this route should point to. Can be anything.
     * @param string $name Optional name of this route. Supply if you want to reverse route this url in your application.
     * @throws \Exception
     *
     * @return Route
     */
    public static function map($method, $route, $target, $name = null) {
        $executable = new Route($method, $route, $target, $name);
        self::$altorouter->map($method, $route, $executable, $name);
        return $executable;
    }

    /**
     * Match a given Request Url against stored routes
     * @param string $requestUrl
     * @param string $requestMethod
     * @return array|boolean Array with route information on success, false on failure (no match).
     */
    public static function match($requestUrl = null, $requestMethod = null) {
        return self::$altorouter->match($requestUrl, $requestMethod);
    }

    /**
     * Reversed routing
     *
     * Generate the URL for a named route. Replace regexes with supplied parameters
     *
     * @param string $routeName The name of the route.
     * @param array @context Associative array of parameters to replace placeholders with.
     * @param array @params URL GET parameters to append.
     *
     * @return string The URL of the route with named parameters in place.
     *
     * @throws Exception
     */
    public static function generate($routeName, array $context = array(), $params = array()) {
        $url = self::$altorouter->generate($routeName, $context);
        $i = 0;
        foreach($params as $name => $value){
            $url .= ($i == 0 ? "?" : "&") . $name . "=" . $value;
            $i++;
        }
        return $url;
    }
}
