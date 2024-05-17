<?php

namespace App\Tests\Services;

use App\Services\CurrencyConvertors\ChainConverter;
use App\Services\CurrencyConvertors\NBUConverter;
use PHPUnit\Framework\TestCase;

class ChainConvertorTest extends TestCase
{
    public function testWhenOneOfServicesFailed()
    {
        $convertors = [
            $this->mockConvertor('12345'),
            $this->mockConvertor(null),
        ];
        $chainConvertor = new ChainConverter(...$convertors);
        $result = $chainConvertor->rate();
        $this->assertEquals('12345', $result);

        $convertors = [
            $this->mockConvertor(null),
            $this->mockConvertor('12345'),
        ];
        $chainConvertor = new ChainConverter(...$convertors);
        $result = $chainConvertor->rate();
        $this->assertEquals('12345', $result);



    }

    private function mockConvertor($resultRate)
    {
        $mock = $this->createMock(NBUConverter::class);
        $mock->method('rate')->willReturn($resultRate);
        return $mock;
    }

}
