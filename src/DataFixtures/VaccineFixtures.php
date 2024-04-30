<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use APP\Entity\Vaccine;

class VaccineFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $vaccine = new Vaccine();
        $vaccine->setName("CHPPiL");
        $vaccine->setMonth2(true);
        $vaccine->setMonth3(true);
        $vaccine->setMonth4(true);
        $vaccine->setYear1(true);
        $vaccine->setAnnual3Recall(true);
        
        $manager->persist($vaccine);

        $vaccine = new Vaccine();
        $vaccine->setName("Rage");
        $vaccine->setMonth3(true);
        $vaccine->setYear1(true);
        $vaccine->setAnnualRecall(true);
        
        $manager->persist($vaccine);

        $manager->flush();
    }
}
