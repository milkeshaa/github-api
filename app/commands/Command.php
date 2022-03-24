<?php

namespace App\Commands;

use App\Enums\HttpMethods;
use App\Traits\HttpRequest;
use App\Traits\Response;

class Command
{
    use HttpRequest;
    use Response;

    public static function list_repositories(string $username): string
    {
        $data = [
            'url' => $_ENV['USERS_URL'] . "$username/repos"
        ];
        $response = self::send_request(HttpMethods::GET->value, $data);
        $response['result'] = json_encode($response['result']);
        return self::prepare_response($response);
    }

    public static function create_repository(string $repo_name): string
    {
        $data = [
            'data' => [ 'name' => $repo_name ],
            'url' => $_ENV['CREATE_URL']
        ];
        var_dump($_ENV['CREATE_URL']);
        $response = self::send_request(HttpMethods::POST->value, $data);
        return self::prepare_response($response);
    }

    public static function delete_repository(string $repo_name): string
    {
        $data = [
            'url' => $_ENV['DELETE_URL'] . $_ENV['GITHUB_USERNAME'] . "/$repo_name"
        ];
        $response = self::send_request(HttpMethods::DELETE->value, $data);
        return self::prepare_response($response);
    }
}