<?php

namespace App\Services;

use GuzzleHttp\Client;

class HttpClient
{
    public function __construct(protected Client $client)
    {
    }


    public function get(string $url): array
    {
        $headers = array(
            'Accept' => 'application/json',
        );
        $response = $this->client->request('GET', $url, [
            'headers' => $headers
        ]);
        $bodyContents = $response->getBody()->getContents();
        if ($response->getStatusCode() !== 200) {
                throw new \Exception('Request failed');
        }

        return json_decode($bodyContents, true);
    }

}
