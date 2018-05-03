<?php namespace SimplexFraam;
/**
 * SimplexFraam Init.
 */
//Require the Composer Autoloader.
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . "/../vendor/autoload.php";

//Load config files.
Config::load();

Router::getInstance();

/**
 * Require Routes.
 */
foreach(glob(__DIR__ . "/../app/routes/*.route.php") as $routeFile){
    require_once $routeFile;
}

$request = Request::createFromGlobals();
$response = (new Response())->forRequest($request);
