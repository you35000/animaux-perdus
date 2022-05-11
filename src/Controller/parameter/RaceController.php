<?php

namespace App\Controller\parameter;

use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/parameter")
 */
class RaceController extends AbstractController
{
    /**
     * @Route("/races", name="app_races")
     */
    public function races(RaceRepository $raceRepository): Response
    {
        return $this->render('admin/races.html.twig', [
            'races'=>$raceRepository->findAll(),
        ]);
    }
}
