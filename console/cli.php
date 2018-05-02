<?php namespace SimplexFraam\CLI;
require_once __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Console\Application;

//Application construct.
$cli = new Application();

//Register commands.
/**
 * Register Commands here.
 */

//execute application.
$cli->run();
