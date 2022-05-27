<?php

namespace App\Controller;

use App\Entity\Declaration;
use App\Form\DeclarationFormType;
use App\Repository\DeclarationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/declaration", name="app_declaration")
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



//    /**
//     * @Route("/", name="app_declaration_index", methods={"GET"})
//     */
//    public function index(DeclarationRepository $declarationRepository): Response
//    {
//        return $this->render('declaration/index.html.twig', [
//            'declarations' => $declarationRepository->findAll(),
//        ]);
//    }

//    /**
//     * @Route("/new/etape2", name="app_declaration_new", methods={"GET", "POST"})
//     */
//    public function new(Request $request, DeclarationRepository $declarationRepository): Response
//    {
//        $declaration = new Declaration();
//        $form = $this->createForm(DeclarationFormType::class, $declaration);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $declarationRepository->add($declaration, true);
//
//            return $this->redirectToRoute('app_declaration_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('declaration/newDeclaration.html.twig', [
//            'declaration' => $declaration,
//            'form' => $form,
//        ]);
//    }

    /**
     * @Route("/{id}", name="_show", methods={"GET"},requirements={"id"="\d+"})
     */
    public function show(Declaration $declaration): Response
    {
        return $this->render('declaration/show.html.twig', [
            'declaration' => $declaration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit", methods={"GET", "POST"})
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

            return $this->redirectToRoute('app_declaration_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('declaration/edit.html.twig', [
            'declaration' => $declaration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="_delete", methods={"POST"})
     */
    public function delete(Request $request, Declaration $declaration, DeclarationRepository $declarationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$declaration->getId(), $request->request->get('_token'))) {
            $declarationRepository->remove($declaration, true);
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
