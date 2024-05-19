<?php

namespace App\Services\CurrencyConvertors;

interface CurrencyConvertorInterface
{
    public function rate($amount, $from, $to);

}
