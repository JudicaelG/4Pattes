<?php

namespace App\Tests\Service;

use App\Entity\Animals;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use App\Service\AddVaccinated;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddVaccinatedTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCalculDateRecallAnnualYear(): void
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

    public function testAddVaccineReturnAnimal(){
        $vaccins = $this->entityManager->getRepository(Vaccine::class)->findAll();
        $animal = new Animals();
        $addVaccinated = new AddVaccinated();
        $vaccinated = $addVaccinated->AddAllVaccineToAnimal($animal, $vaccins, 'chat');
        
        $this->assertEquals($animal, $vaccinated);
    }

    public function testAddVaccineToDog(){
        $vaccins = $this->entityManager->getRepository(Vaccine::class)->findAll();
        $animal = new Animals();
        $addVaccinated = new AddVaccinated();
        $vaccinated = $addVaccinated->AddAllVaccineToAnimal($animal, $vaccins, 'chien');
        foreach($vaccinated->getVaccinateds() as $vaccines){
            foreach($vaccines->getVaccineId() as $vaccine){
                $this->assertEquals('chien', $vaccine->getType());
            }
            
        }
    }

    public function testAddVaccineToCat(){
        $vaccins = $this->entityManager->getRepository(Vaccine::class)->findAll();
        $animal = new Animals();
        $addVaccinated = new AddVaccinated();
        $vaccinated = $addVaccinated->AddAllVaccineToAnimal($animal, $vaccins, 'chat');
        foreach($vaccinated->getVaccinateds() as $vaccines){
            foreach($vaccines->getVaccineId() as $vaccine){
                $this->assertEquals('chat', $vaccine->getType());
            }
            
        }
    }
}
