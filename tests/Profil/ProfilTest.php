<?php

namespace App\Tests\Profil;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilTest extends WebTestCase
{
    private UserPasswordHasherInterface $hasher;

    protected function setUp(): void
    {
        $this->hasher = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testIndex(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        // Test GET request to /animal
        $client->request('GET', '/profil');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();
    }

    public function testInfoUser(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        $client->request('GET', '/profil');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function sendForm(): void{
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        $client->request('GET', '/profil');

        $buttonSubmit = $client->selectButton('submit');

        $form = $buttonSubmit->form();

        $form['form'['email']] = 'judicaelguillaume@outlook.fr';
        $form['form'['password']] = 'Password1234*';

        $client->submit($form);

        $this->assertInputValueSame('email', 'judicaelguillaume@outlook.fr');
        $this->assertInputValueSame('password', 'Password1234*');

    }

    public function userIsModified(): void{
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('judicaelguillaume@outlook.fr');
        //dump($testUser);
        // simulate $testUser being logged in
        $client->loginUser($testUser, 'secured_area');

        $client->request('GET', '/profil');

        $buttonSubmit = $client->selectButton('submit');

        $form = $buttonSubmit->form();

        $form['form'['email']] = 'judicael.guillaume@outlook.fr';
        $form['form'['password']] = 'Password12345*';

        $client->submit($form);

        $modifiedUser = $userRepository->find($testUser->getId());

        $this->assertEquals('judicael.guillaume@outlook.fr', $modifiedUser->getEmail());
        $this->assertEquals($this->hasher->hashPassword($modifiedUser, 'Password12345*'), $modifiedUser->getPassword());
    }
}
