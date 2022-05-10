<?php

namespace App\Controller\parameter;

use App\Repository\EtatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/parameter/admin")
 */
class EtatController extends AbstractController
{
    /**
     * @Route("/etats", name="app_etats")
     */
    public function etats(EtatRepository $etatRepository): Response
    {
        return $this->render('admin/etats.html.twig', [
            'etats'=>$etatRepository->findAll(),
        ]);
    }
}
