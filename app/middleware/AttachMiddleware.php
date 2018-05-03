<?php


namespace PaceMark\LMS;


use SimplexFraam\Middleware;
use SimplexFraam\Response;
use Symfony\Component\HttpFoundation\Request;

class AttachMiddleware extends Middleware
{
    public static function run(Request &$req, Response &$res, $args = [])
    {
        foreach($args as $key => $value){
            $res->assign($key, $value);
        }
    }
}