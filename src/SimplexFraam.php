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
        $route = Router::match();

        //Execute the match
        if( $route ) {
            //Append matched variables into Request object
            foreach($route["params"] as $key => $value){
                $request->query->set($key, $value);
            }

            if(is_string($route['target'])){
                $parts = explode("::", $route["target"]);
                $parts[0] = self::$userNamespace . $parts[0];
                $result = call_user_func_array($parts, [&$request, &$response]);
                if(!empty($result)){
                    $response->assign("result", $result);
                }
            } elseif(is_callable( $route['target'] )) {
                //Execute controller.
                $result = call_user_func_array( $route['target'], [&$request, &$response]);
                if(!empty($result)){
                    $response->assign("result", $result);
                }
            }

        } else {
            $response->error(new Error(404));
        }

        $response->send();

    }
}