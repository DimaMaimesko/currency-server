<?php

namespace App\Services\CurrencyConvertors;

use App\Services\HttpClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Flex\PackageFilter;

class FixerConverter implements CurrencyConvertorInterface
{
    private $targetCurrency = 'USD';

    public function __construct(protected HttpClient $client, protected string $fixerApiKey)
    {

    }

    public function rate($amount, $from, $to): ?string
    {
        $baseUrl = "http://data.fixer.io/api/latest";
        $data = $this->client->get($baseUrl, $this->fixerApiKey);
        if (empty($data['rates'])) {
            return null;
        }

        return $this->findCurrencyInData($data, $amount, $from, $to);
    }



    private function findCurrencyInData(array $data, $amount, $from, $to): ?string
    {
        $usdRate = $data['rates'][$from] ?? 0;
        $uahRate = $data['rates'][$to] ?? 0;
        if(empty($usdRate) || empty($uahRate)){
            return null;
        }

        return (string) (round($uahRate / $usdRate, 5) * $amount);
    }
}
