<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalFormType;
use App\Repository\AnimalRepository;
use App\Repository\EspeceAnimalRepository;
use App\Repository\RaceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */

class AnimalController extends AbstractController
{

//


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="app_animal_index", methods={"GET"})
     */
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }

//
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="app_animal_show", methods={"GET"},requirements={"id"="\d+"})
     */
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/edit", name="app_animal_edit", methods={"GET", "POST"})
     */
    public function edit(
        int $id,
        Request $request,
        AnimalRepository $animalRepository
    ): Response
    {
        $animal = $animalRepository->find($id);

        if ($animal == null) throw new NotFoundHttpException("L'animal n'existe pas");

        $form = $this->createForm(AnimalFormType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $animalRepository->add($animal);
            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="app_animal_form_type_delete", methods={"POST"})
     */
    public function delete(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->request->get('_token'))) {
            $animalRepository->remove($animal);
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}
