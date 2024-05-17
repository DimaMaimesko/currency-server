<?php

namespace App\Controller\Api;

use App\Services\CurrencyConvertors\ChainConverter;
use App\Services\CurrencyConvertors\FixerConverter;
use App\Services\CurrencyConvertors\NBUConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
class CurrencyRateController extends AbstractController
{


    public function __construct(
        protected NBUConverter $nbuConverter,
        protected FixerConverter $fixerConverter)
    {
    }

    #[Route('/api/rate', name: 'get_currency_rate', methods: ['GET'])]
    public function rates()
    {
        $convertor = new ChainConverter(
            $this->nbuConverter,
            $this->fixerConverter,
        );
        $rate = $convertor->rate();

        return $this->json($rate);
    }

}
