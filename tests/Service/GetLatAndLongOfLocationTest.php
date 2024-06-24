<?php

namespace App\Tests\Service;

use App\Service\GetLatAndLongOfLocation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetLatAndLongOfLocationTest extends KernelTestCase{

    private  $locationInformation;

    protected function setUp(): void
    {
       $this->locationInformation = new GetLatAndLongOfLocation("Cirey-sur-vezouze");
    }

    public function testGetLatOfLocation(): void{

        $this->assertEquals('48.5811011', $this->locationInformation->getLat());
    }

    public function testGetLongOfLocation(): void{

        $this->assertEquals('6.9500348', $this->locationInformation->getLong());       

    }
}