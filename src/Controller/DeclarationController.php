<?php

namespace App\Controller;

use App\Entity\Declaration;
use App\Form\DeclarationFormType;
use App\Repository\DeclarationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/internal")
 */

class DeclarationController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/declaration/{id}", name="app_declaration_show", methods={"GET"},requirements={"id"="\d+"})
     */
    public function show(Declaration $declaration): Response
    {
        return $this->render('declaration/show.html.twig', [
            'declaration' => $declaration,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/declaration/{id}/edit", name="app_declaration_edit", methods={"GET", "POST"})
     */
    public function edit(int $id, Request $request, DeclarationRepository $declarationRepository): Response
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
     * @IsGranted("ROLE_USER")
     * @Route("/declaration/{id}", name="app_declaration_delete", methods={"POST"})
     */
    public function delete(Request $request, Declaration $declaration, DeclarationRepository $declarationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$declaration->getId(), $request->request->get('_token'))) {
            $declarationRepository->remove($declaration, true);
        }

        return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
    }
}
