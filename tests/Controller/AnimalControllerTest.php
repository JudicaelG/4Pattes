<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnimalControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/animal');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello world! ✅');
    }
}
