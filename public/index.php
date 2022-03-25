<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any of our classes manually. It's great to relax.
|
*/
require '../vendor/autoload.php';
require '../bootstrap.php';

use App\Utils\Router;

header('Content-Type: application/json;charset=utf-8;');
$router = new Router();
echo $router->process();
