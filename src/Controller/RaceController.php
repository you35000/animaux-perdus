<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{
    /**
     * @Route("/race", name="app_race")
     */
    public function index(): Response
    {
        return $this->render('race/list.html.twig', [
            'controller_name' => 'RaceController',
        ]);
    }
}
