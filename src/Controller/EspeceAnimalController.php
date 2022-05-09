<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspeceAnimalController extends AbstractController
{
    /**
     * @Route("/espece/animal", name="app_espece_animal")
     */
    public function index(): Response
    {
        return $this->render('espece_animal/list.html.twig', [
            'controller_name' => 'EspeceAnimalController',
        ]);
    }
}
