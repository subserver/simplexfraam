<?php namespace SimplexFraam;

use Symfony\Component\HttpFoundation\Request;

abstract class Middleware
{
    /**
     *
     * @param Request   $req HTTP Request Object
     * @param Response  $res HTTP Response Object
     * @param array     $args Optional payload.
     *
     *
     * @return Error|mixed Value on success, Error on fail.
     */
    abstract public static function run(Request &$req, Response &$res, $args = []);
}