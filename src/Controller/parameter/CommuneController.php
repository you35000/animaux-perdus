<?php

namespace App\Controller\parameter;

use App\Repository\CommuneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/parameter/admin")
 */
class CommuneController extends AbstractController
{
    /**
     * @Route("/communes", name="app_communes")
     */
    public function communes(CommuneRepository $communeRepository): Response
    {
        return $this->render('admin/communess.html.twig', [
            'communes'=> $communeRepository->findAll(),
        ]);
    }
}
