<?php

namespace App\Service;

use Symfony\Component\Form\Test\FormInterface;
use App\Entity\Animals;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\Form;

class AddVaccinated{
    public function __construct(){}

    public function RecalculNextRecall(Vaccinated $vaccinated): Vaccinated{
        if($vaccinated->getLastDateInjection()){
            $nextRecall = $this->CalculNextRecall($vaccinated->getVaccineId()->first(), $vaccinated->getLastDateInjection());
            $vaccinated->setNextRecall($nextRecall);            
        }
        
        return $vaccinated;
    }

    public function CalculNextRecall(Vaccine $vaccine, DateTime $lastDateInjection): DateTimeInterface {
        $nextRecall = new DateTime($lastDateInjection->format('Y-m-d'));

        if($vaccine->isAnnualRecall()){
            $nextRecall->modify('+1 Year');
        }

        if($vaccine->isAnnual3Recall())
        {
           $nextRecall->modify('+3 Year');
        }
        
        return $nextRecall;
    }
}