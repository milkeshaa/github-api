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

header('Content-Type: application/json;charset=utf-8;');
$response = [];
switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET': {
        $uri = urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
        $username = htmlspecialchars($_GET['username']);
        if (!$username) {
            if (!isset($_ENV['GITHUB_USERNAME'])) {
                die("Please provide the username (in env, or in URL)");
            }
            $username = $_ENV['GITHUB_USERNAME'];
        }
        if (preg_match('/^\/github\/repos$/', $uri)
            || preg_match('/^\/github\/repos[?&username]/', $uri)) {
            $response = \App\Controllers\RepositoryController::list($username);
        } else {
            http_response_code(404);
        }
        break;
    }
    default: {
        http_response_code(404);
    }
}

echo is_array($response) ? json_encode($response) : $response;
