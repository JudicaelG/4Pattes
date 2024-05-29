<?php

namespace App\Mapper;

use App\DTO\nextRecall;
use App\DTO\VaccinatedDTO;
use App\Entity\Vaccinated;
use Doctrine\ORM\PersistentCollection;

class VaccinatedMapper implements IVaccinatedMapper{
    public function map($vaccinateds): array{
        $vaccinatedsDTO[] = new VaccinatedDTO();

        foreach($vaccinateds as $vaccinated){
            $vaccinatedDTO = new VaccinatedDTO();
            $vaccinatedDTO->id = $vaccinated->getId();
            $vaccinatedDTO->animal_id = $vaccinated->getAnimalId();
            $vaccinatedDTO->vaccine_id = $vaccinated->getVaccineId();
            $vaccinatedDTO->next_recall = $vaccinated->getNextRecall();
            $vaccinatedDTO->last_date_injection = $vaccinated->getLastDateInjection();
            $vaccinatedDTO->color = nextRecall::green;

            array_push($vaccinatedsDTO, $vaccinatedDTO);
        }

        return $vaccinatedsDTO;
    }
}