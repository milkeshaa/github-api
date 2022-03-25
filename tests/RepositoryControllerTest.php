<?php

namespace Tests;

use App\Controllers\RepositoryController;
use App\Enums\Status;

class RepositoryControllerTest
{
    private string $username = '';

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function canListRepositories(): void
    {

        echo "Running canListRepositories test.\n";
        $response = RepositoryController::list($this->username);
        $decoded_response = json_decode($response);
        if ($decoded_response
            && property_exists($decoded_response, 'username')
            && $decoded_response->username === $this->username) {
            echo "Response is successful.\n";
            return;
        }
        echo "Something is wrong. Here is the response: $response\n";
    }

    public function cannotListRepositories(): void
    {
        echo "Running cannotListRepositories test.\n";
        $response = RepositoryController::list('');
        $decoded_response = json_decode($response);
        if ($decoded_response
            && property_exists($decoded_response, 'status')
            && $decoded_response->status === Status::FAILURE->value) {
            echo "Test completed successfully. Failure is catched. Here is the message: $decoded_response->message\n";
            return;
        }
        echo "Something is wrong. Here is the response: $response\n";
    }
}