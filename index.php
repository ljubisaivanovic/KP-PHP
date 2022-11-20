<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$app = new App\Core\Bootstrap();

$app->setRootDirectory(__DIR__);

$app->setDatabaseParameter('TYPE', 'mysql')
    ->setDatabaseParameter('HOST', 'localhost')
    ->setDatabaseParameter('NAME', 'kp')
    ->setDatabaseParameter('USER', 'root')
    ->setDatabaseParameter('PASS', 'root');

$app->router
    ->defineRoute('POST', '/register', 'App\Controllers\AuthController@register')
    ->defineRoute('GET', '/users', 'App\Controllers\UserController@index', true);

$app->boot();
