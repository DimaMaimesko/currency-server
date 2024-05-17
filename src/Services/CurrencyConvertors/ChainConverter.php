<?php

namespace App\Services\CurrencyConvertors;

class ChainConverter implements CurrencyConvertorInterface
{

    private $currencyConvertors;
    public function __construct(CurrencyConvertorInterface ...$currencyConvertors)
    {
        $this->currencyConvertors = $currencyConvertors;
    }

    public function rate()
    {
        foreach ($this->currencyConvertors as $currencyConvertor) {
            $rate = null;
            try {
                $rate = $currencyConvertor->rate();
            } catch (\Exception $e) {

            }

            if ($rate !== null) {
                return $rate;
            }
        }

        return null;
    }

}
