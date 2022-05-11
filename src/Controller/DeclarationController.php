<?php

namespace App\Controller;

use App\Repository\DeclarationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeclarationController extends AbstractController
{
    /**
     * @Route("/", name="app_declaration")
     */
    public function annones(DeclarationRepository $declarationRepository): Response
    {
        return $this->render('home/accueil.html.twig', [
            'annonces'=> $declarationRepository->findAll(),
        ]);
    }
}
