<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    /**
     * @Route("/animal", name="app_animal")
     */
    public function index(): Response
    {
        return $this->render('animal/list.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }
}
