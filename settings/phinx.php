<?php

require_once __DIR__ . "/../vendor/autoload.php";
use SimplexFraam\Config;

// Get PDO object
$pdo = new PDO(
    'mysql:host=' . Config::get("db.host") . ';dbname=' . Config::get("db.name") . ';charset=' . Config::get("db.charset"), Config::get("db.user"), Config::get("db.pass"),
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8 COLLATE utf8_unicode_ci',
    )
);

$settings = [
    'paths' => [
        'migrations' => __DIR__ . '/../db/migrations',
        'seeds' => __DIR__ . '/../db/seeds'
    ],
    'environments' => [
        'default_database' => Config::get("db.name"),
        Config::get("db.name") => [
            'name' => Config::get("db.name"),
            'connection' => $pdo,
        ]
    ]
];

return $settings;
