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

    public function AddVaccine(ArrayCollection $vaccines, Form $dateVaccine, Animals $animal): Animals{
        
        foreach($vaccines as $vaccine){
            $vaccinated = new Vaccinated();
            $vaccinated->addVaccineId($vaccine);
            $vaccinated->addAnimalId($animal);
            $vaccinated->setLastDateInjection(new DateTime($dateVaccine->get('date_'.$vaccine->getName())->getViewData()));
            $vaccinated->setNextRecall($this->CalculNextRecall($vaccine, new DateTime($dateVaccine->get('date_'.$vaccine->getName())->getViewData())));
            $animal->addVaccinated($vaccinated);
        }

        return $animal;
    }

    public function RecalculNextRecall(Vaccinated $vaccinated): Vaccinated{
        $vaccinated->setNextRecall($this->CalculNextRecall($vaccinated->getVaccineId()->first(), $vaccinated->getLastDateInjection()));
        return $vaccinated;
    }

    private function CalculNextRecall(Vaccine $vaccine, DateTime $lastDateInjection): DateTimeInterface {

        if($vaccine->isAnnualRecall()){
            $lastDateInjection->modify('+1 Year');
        }

        if($vaccine->isAnnual3Recall())
        {
           $lastDateInjection->modify('+3 Year');
        }

        return $lastDateInjection;
    }
}