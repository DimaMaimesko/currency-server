<?php

namespace App\Services;

use GuzzleHttp\Client;

class HttpClient
{
    public function __construct(protected Client $client)
    {
    }


    public function get(string $url, $apiKey = null): array
    {
        $headers = array(
            'Accept' => 'application/json',
        );

        $url = $this->prepareUrlWithParams($url, $apiKey);

        $response = $this->client->request('GET', $url, ['headers' => $headers]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Request failed');
        }

        $bodyContents = $response->getBody()->getContents();

        return json_decode($bodyContents, true);
    }

    private function prepareUrlWithParams(string $url, $apiKey): string
    {
        $params = [];
        $existingParams = parse_url($url, PHP_URL_QUERY);
        if ($existingParams) {
            parse_str($existingParams, $params);
        }
        if ($apiKey !== null) {
            $params['access_key'] = $apiKey;
        }
        return strtok($url, '?') . '?' . http_build_query($params);
    }

}
