<?php

namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    public function __construct(protected Client $client)
    {
    }


    public function get(string $url): array
    {
        $response = $this->client->request('GET', $url);
        $bodyContents = $response->getBody()->getContents();
        if ($response->getStatusCode() !== 200) {
                throw new \Exception('Request failed');
        }

        return json_decode($bodyContents, true);
    }

}
