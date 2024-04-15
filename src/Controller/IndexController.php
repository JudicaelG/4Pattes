<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animals;


class IndexController extends AbstractController{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager):Response{


        $animalsOfTheUser = $entityManager->getRepository(Animals::class)
        ->getConnectedUserAnimals($this->getUser()->GetId());

        return $this->render('index.html.twig',[
            'animalsOfTheUser' => $animalsOfTheUser
        ]);
    }    
}