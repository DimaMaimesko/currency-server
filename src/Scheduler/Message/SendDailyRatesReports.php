<?php

namespace App\Scheduler\Message;

class SendDailyRatesReports
{
    public function __construct(
        public int $amount,
        public string $from,
        public string $to
    ) {}


}
