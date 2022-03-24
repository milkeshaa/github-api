<?php

namespace App\Traits;

trait HttpRequest
{
    private static function post(string $json_data, string $url): string
    {
        // Prepare new cURL resource
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);

        // Set HTTP Header for POST request
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/vnd.github.v3+json',
                'User-Agent: Chrome/91.0.4472.114',
                'Authorization: token ' . $_ENV['GITHUB_PERSONAL_TOKEN'],
                'Content-Length: ' . strlen($json_data))
        );

        // Submit the POST request
        $result = curl_exec($curl);

        // Handle cURL error
        if (!$result) {
            die('cURL error: ' . curl_error($curl));
        }

        // Close cURL session handle
        curl_close($curl);
        return $result;
    }

    private static function prepare_data(string $repo_name): string
    {
        $data = array(
            'name' => $repo_name,
            'private' => false,
        );
        return json_encode($data);
    }
}