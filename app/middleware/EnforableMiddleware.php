<?php namespace PaceMark\LMS;


use SimplexFraam\Error;
use SimplexFraam\Middleware;
use SimplexFraam\Response;
use Symfony\Component\HttpFoundation\Request;

class EnforableMiddleware extends Middleware
{
    public static function run(Request &$req, Response &$res, $args = [])
    {
        if(count($args) < 1){
            return false;
        }
        return $args[0] === true;

    }

}