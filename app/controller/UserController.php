<?php namespace PaceMark\LMS;

use SimplexFraam\Response;
use SimplexFraam\Error;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public static function all(Request &$req, Response &$res){
        $res->template("home/home");
        return User::all();
    }

    public static function get(Request &$req, Response &$res){
        $res->template("home/home");
        $res
            ->error(new Error(
                404,
                "User with id `" . $req->get("id") . "` not found"
            ))
            ->send();
        return User::find($req->get("id"));
    }
}