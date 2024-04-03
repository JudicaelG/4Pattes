<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("judicaelguillaume@outlook.fr");
        $user->setPassword($this->hasher->hashPassword($user, 'Password1234*'));
        $user->setIsVerified(true);
        $manager->persist($user);

        $manager->flush();
    }
}
