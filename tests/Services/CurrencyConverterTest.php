<?php

namespace Tests\Services;

use App\Services\CurrencyConverter;
use App\Services\HttpClient;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
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
        $converter = new CurrencyConverter($client);

        $result = $converter->rate();

        $this->assertEquals('39.4305', $result);
    }

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
        $converter = new CurrencyConverter($client);

        $result = $converter->rate();

        $this->assertNull($result);
    }

}
