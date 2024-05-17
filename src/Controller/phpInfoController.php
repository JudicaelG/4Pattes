<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class phpInfoController extends AbstractController
{

    #[Route(path: '/phpinfo', name: 'phpinfo')]
    public function phpinfo()
    {
        phpinfo();
    }
}