<?php


namespace PaceMark\LMS;
use SimplexFraam\DB;

class User
{
    public $id, $name, $username, $email;
    public static function all()
    {
        return DB::getInstance()->user()->fetchAll();
    }

    public static function find($id){
        return ["primary_key" => $id];
    }
}