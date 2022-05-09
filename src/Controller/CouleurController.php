<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouleurController extends AbstractController
{
    /**
     * @Route("/couleur", name="app_couleur")
     */
    public function index(): Response
    {
        return $this->render('couleur/list.html.twig', [
            'controller_name' => 'CouleurController',
        ]);
    }
}
