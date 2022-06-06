<?php

namespace App\Controller;


use App\Entity\Animal;
use App\Entity\Declaration;
use App\Entity\Etat;
use App\Form\AnimalFormType;
use App\Form\DeclarationFormType;
use App\Repository\AnimalRepository;
use App\Repository\DeclarationRepository;
use App\Repository\EspeceAnimalRepository;
use App\Repository\RaceRepository;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonce", name = "app_annonce")
 *
 */
//, name = "app_annonce")
// $this->denyAccessUnlessGranted();

class AnnonceController extends AbstractController

{
    /**
     * @Route("/animal/{id}/edit", name="_edit", methods={"GET", "POST"})
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
            return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/declaration/detail/{id}", name="_detail", methods={"GET"},requirements={"id"="\d+"})
     */
    public function detail($id, DeclarationRepository $declarationRepository): Response
    {
        //TODO s'assurer de bien renvoyer une declaration ou une page 404
        return $this->render('declaration/detail.html.twig', [
            'declaration' => $declarationRepository->find($id),
        ]);
    }

    /**
     * @Route("/declaration/{id}", name="_show", methods={"GET"},requirements={"id"="\d+"})
     */
    public function show(Declaration $declaration): Response
    {
        return $this->render('declaration/show.html.twig', [
            'declaration' => $declaration,
        ]);
    }

    /**
     * @Route("/declaration/{id}/edit", name="_edit5", methods={"GET", "POST"})
     */
    public function edit5(int $id, Request $request, DeclarationRepository $declarationRepository): Response
    {
        $declaration = $declarationRepository->find($id);

        if ($declaration == null) throw new NotFoundHttpException("Cette déclaration n'existe pas");

        $form = $this->createForm(DeclarationFormType::class, $declaration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());

            $this->entityManager->persist($declaration);
            $this->entityManager->flush();

            return $this->redirectToRoute('main_home', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('declaration/edit.html.twig', [
            'declaration' => $declaration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/animal/{id}", name="_detail_animal", methods={"GET"},requirements={"id"="\d+"})
     */
    public function showAnimal(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

}