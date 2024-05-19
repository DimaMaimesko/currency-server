<?php

namespace App\Scheduler\Handler;

use App\Model\Entities\Subscriber;
use App\Notifications\DailyUSDToUAHReport;
use App\Repository\SubscribersRepository;
use App\Scheduler\Message\SendDailyRatesReports;
use App\Services\CurrencyConvertors\ChainConverter;
use App\Services\CurrencyConvertors\FixerConverter;
use App\Services\CurrencyConvertors\NBUConverter;
use App\Services\Mailers\MailtrapSender;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class SendDailyRatesReportsHandler
{

    public function __construct(
        protected LoggerInterface $logger,
        protected EntityManagerInterface $entityManager,
        protected MailtrapSender $sender,
        protected NBUConverter $nbuConverter,
        protected FixerConverter $fixerConverter
    )
    {
    }

    public function __invoke(SendDailyRatesReports $message)
    {
        $rate = $this->calculateRate();
        $this->sendMessagesToSubscribers($rate);
    }

    private function calculateRate()
    {
        $convertor = new ChainConverter($this->nbuConverter, $this->fixerConverter);
        return $convertor->rate();
    }

    private function sendMessagesToSubscribers($rate): void
    {
        $subscribers = $this->entityManager->getRepository(Subscriber::class)->all();

        if (empty($subscribers)) {
            $this->logger->info('No subscribers found.');
            return;
        }

        foreach ($subscribers as $subscriber) {
            $this->sender->send(
                to: $subscriber->getEmail(),
                mail: new DailyUSDToUAHReport($rate)
            );
        }
    }


}
