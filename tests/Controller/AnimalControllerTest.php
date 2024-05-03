<?php

namespace App\Tests\Controller;

use App\Entity\Animals;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnimalControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        // Test GET request to /animal
        $client->request('GET', '/animal');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Assert that the response contains the form
        $this->assertSelectorExists('form');
    }

    public function testEditAnimal()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        // Test GET request to /animal/edit/{id}
        $client->request('GET', '/animal/edit/1');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Assert that the response contains the form
        $this->assertSelectorExists('form');
    }

    public function testDeleteAnimal()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        // Test DELETE request to /animal/delete/{id}
        $client->request('DELETE', '/animal/delete/1');

        // Assert that the response is a redirect
        $this->assertResponseRedirects('/animal');

        // Assert that the animal has been deleted
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $animal = $entityManager->getRepository(Animals::class)->find(1);
        $this->assertNull($animal);
    }
}
