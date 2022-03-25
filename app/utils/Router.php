<?php

namespace App\Utils;

use App\Controllers\RepositoryController;
use App\Enums\HttpMethods;

class Router
{
    private string $query = '';
    private string $uri = '';

    public function __construct()
    {
        $this->uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->query = htmlspecialchars($_GET['username']);
        switch($_SERVER['REQUEST_METHOD'])
        {
            case strtoupper(HttpMethods::GET->value): {
                $this->prepare_query();
                break;
            }
            default: {
                http_response_code(404);
            }
        }
    }

    public function process(): string
    {
        $response = [];
        if (preg_match('/^\/github\/repos$/', $this->uri)
            || preg_match('/^\/github\/repos[?&username]/', $this->uri)) {
            $response = RepositoryController::list($this->query);
        } else {
            http_response_code(404);
        }
        return is_array($response) ? json_encode($response) : $response;
    }

    private function prepare_query()
    {
        if (!$this->query) {
            if (!isset($_ENV['GITHUB_USERNAME'])) {
                die("Please provide the username (in env, or in URL)");
            }
            $this->query = $_ENV['GITHUB_USERNAME'];
        }
    }
}