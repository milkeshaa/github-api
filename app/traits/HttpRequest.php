<?php

namespace App\Traits;

trait HttpRequest
{
    private static function send_request(string $method, array $data = ['data' => [], 'url' => '']): array
    {
        return self::$method($data);
    }

    private static function init_curl(string $url): \CurlHandle|bool
    {
        // Prepare new cURL resource
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        // Set HTTP Header for POST request
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/vnd.github.v3+json',
                'Authorization: token ' . $_ENV['GITHUB_PERSONAL_TOKEN'],
                'User-Agent: Chrome/91.0.4472.114',
        ));

        return $curl;
    }

    private static function post(array $data): array
    {
        $json_data = json_encode($data['data']);
        $curl = self::init_curl($data['url']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);

        return self::submit($curl);
    }

    private static function delete(array $data): array
    {
        $curl = self::init_curl($data['url']);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

        return self::submit($curl);
    }

    private static function submit($curl): array
    {
        // Submit the request
        $result = curl_exec($curl);
        // Handle cURL error
        if (!$result && ($curl_error = curl_error($curl))) {
            die("cURL error: $curl_error\n");
        }
        // Close cURL session handle
        curl_close($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        return ['result' => $result, 'code' => $http_code];
    }
}