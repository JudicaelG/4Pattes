<?php

namespace App\MessageHandler;

use App\Message\SendEmailNextVaccineMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Notifier\NotifierInterface;

#[AsMessageHandler]
final class SendEmailNextVaccineMessageHandler
{

    public function __construct(private EntityManagerInterface $entityManagerInterface, private NotifierInterface $notifier)
    {
        
    }

    public function __invoke(SendEmailNextVaccineMessage $message)
    {
        $message->sendEmail($this->entityManagerInterface, $this->notifier);
       

    }
}
