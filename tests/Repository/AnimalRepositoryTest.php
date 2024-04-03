<?php

namespace App\Tests\Repository;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;
use App\Entity\Animals;
use App\Entity\User;
use App\Entity\Breed;

class AnimalRepositoryTest extends KernelTestCase
{

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSaveEntity(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $breedRepository = $this->entityManager->getRepository(Breed::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        $breed = $breedRepository->findOneByName('Border-collie');

        $animal = new Animals();
        $animal->setName("Test");
        $animal->SetBirthday(new \DateTime());
        $animal->SetBreedId($breed);
        $animal->SetUserId($testUser);

        $animalInsert = $this->entityManager->getRepository(Animals::class)
        ->saveAnimal($animal);

        $this->assertsame('Your animal has been added !', $animalInsert);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
