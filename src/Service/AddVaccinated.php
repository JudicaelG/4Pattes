<?php

namespace App\Service;

use App\Entity\Animals;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use DateTime;
use DateTimeInterface;

class AddVaccinated{
    public function __construct(){}

    public function RecalculNextRecall(Vaccinated $vaccinated): Vaccinated{
        if($vaccinated->getLastDateInjection() != null){
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

    public function AddAllVaccineToAnimal(Animals $animal, array $vaccins, string $typeVaccin): Animals{
        foreach($vaccins as $vaccin){
            if($vaccin->getType() == $typeVaccin){
                
                $vaccinated = new Vaccinated();
                $vaccinated->addVaccineId($vaccin);
                $animal->addVaccinated($vaccinated);
            }
                        
        }
        return $animal;
    }
}