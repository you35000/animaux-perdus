<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Repository\DepartementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function utilisateurs(UserRepository $userRepository): Response
    {
        return $this->render('admin/utilisateurs.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/departements", name="departements")
     */
    public function departements(DepartementRepository $departementRepository): Response
    {
        return $this->render('admin/departements.html.twig', [
           'departements'=> $departementRepository->findAll(),
        ]);
    }
}
