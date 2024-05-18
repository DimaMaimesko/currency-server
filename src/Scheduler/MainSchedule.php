<?php

namespace App\Scheduler;

use App\Scheduler\Message\SendDailyRatesReports;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\Scheduler;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
final class MainSchedule implements ScheduleProviderInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(
                // @TODO - Create a Message to schedule
                RecurringMessage::every('10 seconds', new SendDailyRatesReports()),
                RecurringMessage::cron('@daily', new SendDailyRatesReports())
            );
        ;
    }
}
