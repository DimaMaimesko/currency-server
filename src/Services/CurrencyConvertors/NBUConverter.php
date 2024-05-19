<?php

namespace App\Services\CurrencyConvertors;

use App\Services\HttpClient;

class NBUConverter implements CurrencyConvertorInterface
{
    private $baseUri = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';


    public function __construct(protected HttpClient $client)
    {

    }

    public function rate($amount, $from, $to): ?string
    {
        $targetCurrency = $from;
        $data = $this->client->get($this->baseUri);
        if (empty($data)) {
            return null;
        }

        return $this->findCurrencyInData($data, $targetCurrency);
    }



    private function findCurrencyInData(array $data, string $currencyCode): ?string
    {
        foreach ($data as $entry) {
            if ($entry['cc'] === $currencyCode) {
                return $entry['rate'] ?? null;
            }
        }

        return null;
    }
}
