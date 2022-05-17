<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalFormType;
use App\Repository\AnimalRepository;
use App\Repository\EspeceAnimalRepository;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/animal")
 */
class AnimalController extends AbstractController
{
    /**
     * @Route("/", name="app_animal_index", methods={"GET"})
     */
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_animal_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AnimalRepository $animalRepository): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalFormType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $animalRepository->add($animal);
            return $this->redirectToRoute('app_animal_index');
        }

        $currentUrl = $this->generateUrl('app_animal_ajax_races');

        return $this->renderForm('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
            'currentUrl' => $currentUrl,
        ]);
    }

    /**
     * @Route("/ajax/races", name="app_animal_ajax_races", methods={"POST"})
     */
    public function ajaxGetRaces(
        Request $request,
        AnimalRepository $animalRepository,
        RaceRepository $raceRepository,
        EspeceAnimalRepository $especeAnimalRepository
    ): JsonResponse
    {
        $datas = json_decode($request->getContent(), true);

        $getEspeces = $especeAnimalRepository->findOneBy(['id' => $datas["id"]]);

        if ($getEspeces == null) {
            return new JsonResponse(["error" => "Aucune race ne correspond à cette espèce"]);
        }

        $races = $getEspeces->getRaces();
        $rep = [];
        $index = 0;
        foreach ($races as $race) {
            $rep[$index] = [
                "id" => $race->getId(),
                "code" => $race->getCode(),
                "nom" => $race->getNom(),
            ];

            $index++;
        }

        return new JsonResponse($rep);
    }

    /**
     * @Route("/{id}", name="app_animal_show", methods={"GET"})
     */
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_animal_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        $form = $this->createForm(AnimalFormType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->add($animal);
            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal_form_type/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    /**
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
