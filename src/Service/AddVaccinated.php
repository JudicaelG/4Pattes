<?php

namespace App\Service;

use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use DateTime;
use DateTimeInterface;

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