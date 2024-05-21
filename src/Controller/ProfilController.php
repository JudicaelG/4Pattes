<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface as GoogleAuthenticatorTwoFactorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{


    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, TokenStorageInterface $tokenStorage): Response
    {

        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $userToken = $tokenStorage->getToken()->getUser();

        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            if($form->get('email')->getData()){
                $user->setEmail($form->get('email')->getData());
            }
            if($form->get('password')->getData()){
                $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('password')->getData()));
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_profil');

        }

        return $this->render('profil/index.html.twig', [
            'form' => $form,
            "displayQrCodeGa" => $userToken instanceof GoogleAuthenticatorTwoFactorInterface && $userToken->isGoogleAuthenticatorEnabled(),
        ]);
    }
}
