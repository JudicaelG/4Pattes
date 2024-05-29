<?php

namespace App\Scheduler;

use App\Message\SendEmailNextVaccineMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
final class SendEmailNextVaccineSchedule implements ScheduleProviderInterface
{
    public function __construct(
        private CacheInterface $cache,
        private EntityManagerInterface $entitymanager,
        private NotifierInterface $notifier
    ) {

    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(
                // @TODO - Modify the frequency to suite your needs
                RecurringMessage::cron('@monthly', new SendEmailNextVaccineMessage()),
            )
            ->stateful($this->cache)
        ;
    }
}
