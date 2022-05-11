<?php

namespace App\Controller\parameter;

use App\Repository\EspeceAnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/parameter")
 */
class EspeceAnimalController extends AbstractController
{
    /**
     * @Route("/espece-animal", name="app_espece_animal")
     */
    public function especes(EspeceAnimalRepository $especeAnimalRepository): Response
    {
        return $this->render('admin/especes-animal.html.twig', [
            'especes'=>$especeAnimalRepository->findAll(),
        ]);
    }
}
