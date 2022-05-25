<?php
namespace App\Controller;

use App\Repository\DeclarationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home"), methods={"GET"})
     */
    public function index(DeclarationRepository $declarationRepository): Response
    {
        return $this->render('main/accueil.html.twig', [
            'declarations' => $declarationRepository->findAll(),
        ]);
    }
}