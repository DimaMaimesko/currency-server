<?php

namespace App\Scheduler;

use App\Scheduler\Message\SendDailyRatesReports;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule]
final class MainSchedule implements ScheduleProviderInterface
{
    public function __construct() {
    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(
                RecurringMessage::cron('@daily', new SendDailyRatesReports(1, 'USD', 'UAH'))
            );
    }
}
