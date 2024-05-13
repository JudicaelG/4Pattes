<?php

namespace App\Tests\Service;

use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use App\Service\AddVaccinated;
use DateTime;
use PHPUnit\Framework\TestCase;

class AddVaccinatedTest extends TestCase
{
    public function testCalculDateRecallAnnualYear(): void
    {
           $vaccine = new Vaccine();
           $vaccine->setName('vaccine');
           $vaccine->setAnnualRecall(true);
           $vaccine->setMonth3(true);

           $vaccinated = new Vaccinated();
           $vaccinated->addVaccineId($vaccine);
           $vaccinated->setLastDateInjection(new DateTime('2024-05-13'));
            dump($vaccinated);
           $addVaccinated = new AddVaccinated();

           $vaccinated = $addVaccinated->RecalculNextRecall($vaccinated);
           dump($vaccinated);

           $this->assertEquals(new DateTime('2025-05-13'), $vaccinated->getNextRecall());
    }

    public function testLastDateInjectionIsNotRecalculate(): void
    {
        $vaccine = new Vaccine();
        $vaccine->setName('vaccine');
        $vaccine->setAnnualRecall(true);
        $vaccine->setMonth3(true);

        $vaccinated = new Vaccinated();
        $vaccinated->addVaccineId($vaccine);
        $vaccinated->setLastDateInjection(new DateTime('2024-05-13'));
        $addVaccinated = new AddVaccinated();
        $vaccinated = $addVaccinated->RecalculNextRecall($vaccinated);

        $this->assertEquals(new DateTime('2024-05-13'), $vaccinated->getLastDateInjection());
    }
}
