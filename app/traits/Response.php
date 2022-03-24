<?php

namespace App\Traits;

use App\Enums\Status;

trait Response
{
    private static function prepare_response(array $response): string
    {
        $result = json_decode($response['result']);
        if ($result && property_exists($result, "errors") || $response['code'] >= 400) {
            return json_encode([
                'code' => $response['code'],
                'status' => Status::FAILURE->value,
                'result' => $response
            ]);
        }

        return json_encode([
            'code' => $response['code'],
            'status' => Status::SUCCESS->value,
            'result' => $result
        ]);
    }
}