<?php

namespace  App\Tests\Services;

use App\Services\CurrencyConvertors\FixerConverter;
use App\Services\HttpClient;
use PHPUnit\Framework\TestCase;

class FixerConverterTest extends TestCase
{
    /**
     * A basic test example.
     * @group test
     * @return void
     */
    public function testSuccess(): void
    {
        $httpClientResponse = [
            "success" => true,
            "timestamp" => 1715891644,
            "base" => "EUR",
            "date" => "2024-05-16",
            "rates" => [
                "AED" => 3.991373,
                "AFN" => 77.696763,
                "UAH" => 42.756754,
                "UGX" => 4086.133992,
                "USD" => 1.086709
            ]
        ];

        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn($httpClientResponse);

        $apiKey = 'bd5ecd38484cafed7bf29a7e8ff5bab3';
        $converter = new FixerConverter($client, $apiKey);

        $result = $converter->rate(1, 'USD', 'UAH');

        $this->assertEquals('39.34517', $result);
    }

    /**
     * A basic test example.
     * @group test
     * @return void
     */
    public function testUSDNotFound(): void
    {
        $httpClientResponse = [
            "success" => true,
            "timestamp" => 1715891644,
            "base" => "EUR",
            "date" => "2024-05-16",
            "rates" => [
                "AED" => 3.991373,
                "AFN" => 77.696763,
                "UAH" => 42.756754,
                "UGX" => 4086.133992,
                "USD" => 0
            ]
        ];

        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn($httpClientResponse);
        $apiKey = 'bd5ecd38484cafed7bf29a7e8ff5bab3';
        $converter = new FixerConverter($client, $apiKey);

        $result = $converter->rate(1, 'USD', 'UAH');

        $this->assertNull($result);
    }
}
