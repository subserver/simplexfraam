<?php namespace SimplexFraam\CLI;
require_once __DIR__ . "/../vendor/autoload.php";

use SimplexFraam\SetupFolderStructure;
use Symfony\Component\Console\Application;

//Application construct.
$cli = new Application();

//Register commands.
/**
 * Register Commands here.
 */

$cli->add(new SetupFolderStructure());

//execute application.
$cli->run();
