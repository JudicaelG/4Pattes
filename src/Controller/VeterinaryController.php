<?php

namespace App\Controller;

use App\Entity\Veterinary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VeterinaryController extends AbstractController
{
    #[Route('/veterinary', name: 'app_veterinary')]
    public function index(): Response
    {


        return $this->render('veterinary/index.html.twig', [
            'controller_name' => 'VeterinaryController',
        ]);
    }

    #[Route('/veterinary/edit/{id}', name: 'app_veterinary_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $veterinary = $entityManager->getRepository(Veterinary::class)->find($id);
        if(!$veterinary){
            return $this->redirect($request->headers->get('referer'));
        }
        
        foreach($request->request as $veterinaryRequest){
            $veterinary->setName($veterinaryRequest['name']);
            $veterinary->setAdress($veterinaryRequest['adress']);
            $veterinary->setpostalCode($veterinaryRequest['postalCode']);
            $veterinary->setCity($veterinaryRequest['city']);
            $veterinary->setPhone($veterinaryRequest['phone']);
            $entityManager->flush();
        }

        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }
}
