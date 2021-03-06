<?php

namespace App\Controller;

use App\Entity\Declaration;
use App\Entity\Etat;
use App\Entity\Secteur;
use App\Form\DeclarationFormType;
use App\Form\SecteurFormType;
use App\Repository\DeclarationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/internal", name = "app_declaration")
 */

class DeclarationController extends AbstractController
{





//    /**
//     * @IsGranted("ROLE_USER")
//     * @Route("/annonce", name="_step_one", methods={"GET", "POST"})
//     */
//    public function newDeclaration(Request $request, DeclarationRepository $declarationRepository): Response
//    {
//        $declaration = new Declaration();
//        $form = $this->createForm(DeclarationFormType::class, $declaration);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $declarationRepository->add($declaration, true);
//
//            return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('annonce/newDeclarationVue.html.twig', [
//            'declaration' => $declaration,
//            'form' => $form,
//        ]);
//    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/new-declaration", name="_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $declaration = new Declaration();
        $declarationForm = $this->createForm(DeclarationFormType::class,$declaration );
        $secteur = new Secteur();
        $secteurForm = $this->createForm(SecteurFormType::class, $secteur, [
            'method' => 'POST',
        ]);
        $declarationForm->handleRequest($request);
        if ($declarationForm->isSubmitted() && $declarationForm->isValid()) {
            $declaration->setEtats($em->getRepository(Etat::class)->findOneBy(['libelle' => 'Recherche en cours']));
            $em->persist($declaration);
            $em->flush();
            $this->addFlash('success', 'la d??claration est cr????e !');

            return $this->redirectToRoute('app_annonce_show', ['id' => $declaration->getId()]);
        }
        return $this->render('declaration/newDeclarationVue.html.twig', [
            'form' => $declarationForm->createView(),
            'secteurForm' => $secteurForm->createView(),
        ]);
    }


//

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/declaration/{id}", name="_delete", methods={"POST"})
     */
    public function delete(Request $request, Declaration $declaration, DeclarationRepository $declarationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$declaration->getId(), $request->request->get('_token'))) {
            $declarationRepository->remove($declaration, true);
        }

        return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
    }

//    /**
//     * @IsGranted("ROLE_USER")
//     * @Route("/new-declaration", name="_new", methods={"GET", "POST"})
//     */
//    public function new(Request $request, EntityManagerInterface $em): Response
//    {
//        $declaration = new Declaration();
//        $declarationForm = $this->createForm(DeclarationFormType::class,$declaration );
//        $secteur = new Secteur();
//        $secteurForm = $this->createForm(SecteurFormType::class, $secteur, [
//            'method' => 'POST',
//            //permet d'avoir l'attribut action avec l'url
////            'action' => $this->generateUrl('secteur_create')
//        ]);
////        $currentUrl = $this->generateUrl('app_declaration_ajax_races');
//        $declarationForm->handleRequest($request);
//        if ($declarationForm->isSubmitted() && $declarationForm->isValid()) {
////
//            $declaration->setEtats($em->getRepository(Etat::class)->findOneBy(['libelle' => 'Recherche en cours']));
////                $this->addFlash('success', 'Votre declaration ' . $Declaration->getId() . ' a bien ??t?? cr????e');
//            $em->persist($declaration);
//            $em->flush();
//            $this->addFlash('success', 'la d??claration est cr????e !');
////            return $this->redirectToRoute('main_home');
//            return $this->redirectToRoute('app_annonce_show', ['id' => $declaration->getId()]);
//        }
//
//        return $this->render('declaration/newDeclarationVue.html.twig', [
//            'form' => $declarationForm->createView(),
//            'secteurForm' => $secteurForm->createView(),
//        ]);
//    }


}
