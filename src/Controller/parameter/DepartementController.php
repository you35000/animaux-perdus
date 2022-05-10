<?php

namespace App\Controller\parameter;


use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/parameter/admin")
 */
class DepartementController extends AbstractController
{
    /**
     * @Route("/departements", name="app_departements")
     */
    public function departements(DepartementRepository $departementRepository): Response
    {
        return $this->render('admin/departements.html.twig', [
            'departements'=> $departementRepository->findAll(),
        ]);
    }

}
