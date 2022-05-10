<?php

namespace App\Controller;

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
     * @Route("/utilisateurs", name="app_utilisateurs")
     */
    public function utilisateurs(UserRepository $userRepository): Response
    {
        return $this->render('admin/utilisateurs.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }



}
