<?php namespace SimplexFraam;

use Symfony\Component\HttpFoundation\Request;
/**
 * Class SimplexFraam
 *
 * @package SimplexFraam
 */
class SimplexFraam
{
    public static $userNamespace = "\\";
    public static function setNamespace($namespace){
        self::$userNamespace = $namespace;
    }

    public static function execute(Request &$request, Response &$response){
        $matched = Router::match();

        //Execute the match
        if( $matched ) {
            //Append matched variables into Request object
            foreach($matched["params"] as $key => $value){
                $request->query->set($key, $value);
            }

            $route = $matched["target"];
            $route->run($request, $response);

        } else {
            $response->error(new Error(404));
        }

        $response->send();

    }
}