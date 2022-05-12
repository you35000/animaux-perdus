<?php

namespace App\Controller\parameter;

use App\Repository\CouleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/parameter")
 */
class CouleurController extends AbstractController
{
    /**
     * @Route("/couleurs", name="app_couleurs")
     */
    public function couleurs(CouleurRepository $couleurRepository): Response
    {
        return $this->render('admin/couleurs.html.twig', [
            'couleurs'=> $couleurRepository->findAll(),
        ]);
    }
}
