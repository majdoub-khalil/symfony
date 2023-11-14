<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeuserController extends AbstractController
{
    #[Route('/homeuser', name: 'app_homeuser')]
    public function index(): Response
    {
        return $this->render('homeuser/index.html.twig', [
            'controller_name' => 'HomeuserController',
        ]);
    }
}
