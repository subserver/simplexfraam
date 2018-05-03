<?php
/**
 * Simplexfraam,
 * Basic collection of libraries to make a base for developing web applications in PHP.
 *
 * @author Ryan Tiedemann <ryan.peter.t@gmail.com>
 */
use SimplexFraam\SimplexFraam;

if(isset($argv[1]) && in_array($argv[1], ["GET", "POST", "DELETE"]) && isset($argv[2])) {
    $_SERVER['REQUEST_METHOD'] = $argv[1];

    $parts = explode("?", $argv[2]);
    if(isset($parts[1])){
        foreach(explode("&", $parts[1]) as $param){
            list($key, $value) = explode("=", $param);
            $_GET[$key] = $value;
        }
    }
    $_SERVER['REQUEST_URI'] = $parts[0];
}
elseif (isset($argv[1]) && $argv[1] !== null){
    $_SERVER['REQUEST_METHOD'] = "GET";
    $parts = explode("?", $argv[1]);
    if(isset($parts[1])){
        foreach(explode("&", $parts[1]) as $param){
            list($key, $value) = explode("=", $param);
            $_GET[$key] = $value;
        }
    }
    $_SERVER['REQUEST_URI'] = $parts[0];
}

require_once __DIR__ . "/../src/bootstrap.php";
/**
 * Import Variables for IDE.
 * @var \Symfony\Component\HttpFoundation\Request $request
 * @var \SimplexFraam\Response $response
 */
/** CUSTOM CODE */



if(isset($_GET["format"])){
    $response->setResponseFormat(strtolower($_GET["format"]));
} elseif (isset($argv[0]) && $argv[0] !== null){
    $response->setResponseFormat(\SimplexFraam\Response::RESPONSE_JSON);
}


/** /CUSTOM CODE */
SimplexFraam::setNamespace("PaceMark\LMS\\");
SimplexFraam::execute($request, $response);
echo "\n";

