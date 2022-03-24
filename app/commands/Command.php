<?php

namespace App\Commands;

use App\Enums\Status;
use App\Traits\HttpRequest;

class Command
{
    use HttpRequest;

    public static function create_repository(string $repo_name): string
    {
        $json_data = self::prepare_data($repo_name);
        $response = json_decode(self::post($json_data, $_ENV['CREATE_URL']));
        if (property_exists($response, "errors")) {
            return json_encode(['status' => Status::FAILURE->value, 'result' => $response]);
        }

        return json_encode(['status' => Status::SUCCESS->value, 'result' => $response]);
    }
}