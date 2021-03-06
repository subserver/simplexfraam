<?php namespace PaceMark\LMS;

use SimplexFraam\Router;

//Users Group
Router::map("GET", "/", "UserController::all", "home")
    ->before("AttachMiddleware", ["result" => "before value"])
    ->enforce("EnforableMiddleware", [true])
    ->after("AttachMiddleware", ["after" => "after value"]);

Router::map("GET", "/users", "UserController::all", "user_all");
Router::map("POST", "/users", "UserController::create", "user_new");

//Specific User
Router::map("GET", "/users/[i:id]", "UserController::get", "user_get");
Router::map("POST", "/users/[i:id]", "UserController::update", "user_update");
Router::map("DELETE", "/users/[i:id]", "UserController::delete", "user_delete");