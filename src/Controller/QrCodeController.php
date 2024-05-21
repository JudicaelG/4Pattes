<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface as GoogleAuthenticatorTwoFactorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class QrCodeController extends AbstractController
{
    #[Route('/activate/2fa', name: 'app_activate_2fa')]
    public function activate2Fa(GoogleAuthenticatorInterface $googleAuthenticator, EntityManagerInterface $entityManager): Response
    {   
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

                
        $secret = $googleAuthenticator->generateSecret();
        $user->setGoogleAuthenticatorSecret($secret);

        $entityManager->flush();
        
        return $this->redirectToRoute('app_profil');
    }
}