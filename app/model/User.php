<?php


namespace PaceMark\LMS;


class User
{
    public $id, $name, $username, $email;
    public static function all()
    {
        return [new User()];
    }

    public static function find($id){
        return ["primary_key" => $id];
    }
}