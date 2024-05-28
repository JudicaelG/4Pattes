<?php

namespace App\Message;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

final class SendEmailNextVaccineMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    public function __construct(
         public readonly EntityManagerInterface $entityManager,
         public readonly NotifierInterface $notifier
    ) {
    }


    public function sendEmail(){
        $nextRecalls = $this->get_all_next_vaccine();
        dump($nextRecalls);
        die();
        foreach($nextRecalls as $nextRecall){
            $notification = (new Notification('Rappel vaccin pour '.$nextRecall->a_name(), ['email'] ))
            ->content('le vaccin '.$nextRecall->a_vaccine().' doit être fait avant le '.$nextRecall.next_recall());

            $recipient = new Recipient($nextRecall->email());

            $this->notifier->send($notification, $recipient);
        }

    }

    private function get_all_next_vaccine(): array{
        $nextRecall = $this->entityManager->createQuery(
            'SELECT * FROM get_month_next_recall_vaccine'
        );

        return $nextRecall->getResult();
    }


}
