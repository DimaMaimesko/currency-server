<?php

namespace  App\Tests\Services;

use App\Services\CurrencyConvertors\NBUConverter;
use App\Services\HttpClient;
use PHPUnit\Framework\TestCase;

class NBUConverterTest extends TestCase
{
    /**
     * A basic test example.
     * @group test
     * @return void
     */
    public function testSuccess(): void
    {
        $httpClientResponse = [
            [
                "r030" => 841,
                "txt" => "Евро",
                "rate" => 39.4305,
                "cc" => "ABC",
                "exchangedate" => "17.05.2024",
            ],
            [
                "r030" => 840,
                "txt" => "Долар США",
                "rate" => 39.4305,
                "cc" => "USD",
                "exchangedate" => "17.05.2024",
            ],
            [
                "r030" => 843,
                "txt" => "Тугрик",
                "rate" => 29.4305,
                "cc" => "XYZ",
                "exchangedate" => "17.05.2024",
            ]
        ];

        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn($httpClientResponse);
        $converter = new NBUConverter($client);

        $result = $converter->rate(1, 'USD', 'UAH');

        $this->assertEquals('39.4305', $result);
    }

    /**
     * A basic test example.
     * @group test
     * @return void
     */
    public function testUSDNotFound(): void
    {
        $httpClientResponse = [
            [
                "r030" => 841,
                "txt" => "Евро",
                "rate" => 39.4305,
                "cc" => "ABC",
                "exchangedate" => "17.05.2024",
            ],
            [
                "r030" => 843,
                "txt" => "Тугрик",
                "rate" => 29.4305,
                "cc" => "XYZ",
                "exchangedate" => "17.05.2024",
            ]
        ];

        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn($httpClientResponse);
        $converter = new NBUConverter($client);

        $result = $converter->rate(1, 'USD', 'UAH');

        $this->assertNull($result);
    }


}
