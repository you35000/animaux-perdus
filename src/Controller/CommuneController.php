<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommuneController extends AbstractController
{
    /**
     * @Route("/commune", name="app_commune")
     */
    public function index(): Response
    {
        return $this->render('commune/list.html.twig', [
            'controller_name' => 'CommuneController',
        ]);
    }
}
