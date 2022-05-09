<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecteurController extends AbstractController
{
    /**
     * @Route("/secteur", name="app_secteur")
     */
    public function index(): Response
    {
        return $this->render('secteur/list.html.twig', [
            'controller_name' => 'SecteurController',
        ]);
    }
}
