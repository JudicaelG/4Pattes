<?php

namespace App\Message;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
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
    ) {
    }


    public function sendEmail(EntityManagerInterface $entityManager, NotifierInterface $notifier){
        $nextRecalls = $this->get_all_next_vaccine($entityManager);
        foreach($nextRecalls as $nextRecall){
            if($nextRecall["months"] == 1){
                $notification = (new Notification('Rappel vaccin pour '.$nextRecall["a_name"], ['email'] ))
                ->content('le vaccin '.$nextRecall["v_name"].' doit être fait avant le '.date("d/m/Y", strtotime($nextRecall["next_recall"])));
    
                $recipient = new Recipient($nextRecall["email"]);
    
                $notifier->send($notification, $recipient);
            }            
        }

    }

    private function get_all_next_vaccine(EntityManagerInterface $entityManager): array{

        $conn = $entityManager->getConnection();

        $sql = 'SELECT * FROM get_month_next_recall_vaccine';

        $resulSet = $conn->executeQuery($sql);
        /*$rsm = new ResultSetMapping();
        $query = $entityManager->createNativeQuery(
            'SELECT * FROM get_month_next_recall_vaccine', $rsm
        );*/
        /*dump($resulSet->fetchAllAssociative());
        die();*/
        return $resulSet->fetchAllAssociative();
    }


}
