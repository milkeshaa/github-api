<?php

namespace App\Controllers;

use App\Commands\Command as CLI;

class RepositoryController
{
    public static function list(string $username): string
    {
        $data = CLI::list_repositories($username);
        $response = json_decode($data);
        $styled_response = ['username' => $username, 'repositories' => []];
        if ($response && property_exists($response, "result")) {
            $repos = json_decode($response->result);
            $styled_response['repositories'] = array_map(function ($repo) {
                return (object)[
                    'full_name' => $repo->full_name,
                    'url' => $repo->html_url
                ];
            }, $repos);
        }
        return json_encode($styled_response);
    }
}