<?php
namespace App\Controller;

use App\Repository\DeclarationRepository;
use App\Repository\SignalementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home"), methods={"GET"})
     */
    public function getLists(  SignalementRepository $signalementRepository,
                               DeclarationRepository $declarationsRepository ): Response
    {
        return $this->render('main/accueil.html.twig', [

            $signalements = $signalementRepository->findAll(),
            $declarations = $declarationsRepository->findAll(),

            'signalements' => $signalements,
            'declarations' => $declarations,
        ]);
    }
}