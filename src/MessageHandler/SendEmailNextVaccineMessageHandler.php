<?php

namespace App\MessageHandler;

use App\Message\SendEmailNextVaccineMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendEmailNextVaccineMessageHandler
{
    public function __invoke(SendEmailNextVaccineMessage $message)
    {
        $message->sendEmail();
    }
}
