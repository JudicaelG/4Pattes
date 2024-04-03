<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Breed;

class BreedFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $breed = new Breed();
        $breed->setName("Border-collie");
        $manager->persist($breed);

        $manager->flush();
    }
}
