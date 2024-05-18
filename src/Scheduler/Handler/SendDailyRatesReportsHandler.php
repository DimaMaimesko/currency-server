<?php

namespace App\Scheduler\Handler;

use App\Scheduler\Message\SendDailyRatesReports;
use Psr\Log\LoggerInterface;

class SendDailyRatesReportsHandler
{

    public function __construct(protected LoggerInterface $logger)
    {
    }

    public function __invoke(SendDailyRatesReports $message)
    {
        // TODO: Implement __invoke() method.
        $this->logger->info('Sending daily rates reports to all subscribers...');
    }

}
