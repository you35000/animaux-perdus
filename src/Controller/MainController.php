<?php
namespace App\Controller;

use App\Entity\Declaration;
use App\Entity\Secteur;
use App\Form\SearchFormType;
use App\Repository\DeclarationRepository;
use App\Repository\SignalementRepository;
use App\Service\UpdateEtat;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home"), methods={"GET"})
     */
//    public function getLists(SignalementRepository $signalementRepository,
//                             DeclarationRepository $declarationsRepository): Response
//    {
//        return $this->render('main/accueil.html.twig', [
//
//            $signalements = $signalementRepository->findAll(),
//            $declarations = $declarationsRepository->findAll(),
//
//            'signalements' => $signalements,
//            'declarations' => $declarations,
//        ]);
//    }

    public function index(Request $request,DeclarationRepository $declarationRepository,
                          EntityManagerInterface $mgr,
                          SignalementRepository $signalementRepository,
                          UpdateEtat $updateEtat,
                          PaginatorInterface $paginator): Response
    {
//        $updateEtat->updateDeclarations();
        $signalements = $signalementRepository->findAll();
        $declarations = $declarationRepository->findAll();

        $formSearch = $this->createForm(SearchFormType::class, null, [
            'action' => $this->generateUrl('main_home'),
            'method' => 'GET',
        ]);

        $formSearch->handleRequest($request);
        if ($formSearch->isSubmitted() && $formSearch->isValid()){
            $searchDeclaration = $formSearch ['secteurs']->getData();
            $declarations = $mgr->getRepository(Declaration::class)->filters($searchDeclaration);
//            $searchAnimal = $formSearch ['animaux']->getData();

            //dd($searchDeclaration);

            //Pagination des sorties :
            $declarationToDisplay = $paginator->paginate($declarations, $request->query->getInt('page', 1), 6);

            return $this->render('main/accueil.html.twig', [
//            return $this->render('main/accueil.html.twig', [
                'formSearch' => $formSearch->createView(),
                 'annonces' =>$declarationToDisplay,
                'signalements' => $signalements,
                'declarations' => $declarationRepository->findByFiltre($searchDeclaration )

            ]);
        }
        $declarationToDisplay = $paginator->paginate($declarations, $request->query->getInt('page', 1), 6);
        return $this->render('main/accueil.html.twig', [
//        return $this->render('main/accueil.html.twig', [
            'formSearch' => $formSearch->createView(),
            'annonces' =>$declarationToDisplay,
            'signalements' => $signalements,
            'declarations' =>$declarationRepository->findDefault(),
        ]);

    }
///////////////////////////////////////////////////////////////////////////////////
//    public function index(Request $req, EntityManagerInterface $mgr, UpdateEtat $updateEtat, PaginatorInterface $paginator): Response
//    {
//        $updateEtat->updateDeclaration();
//        $declarations = $mgr->getRepository(Declaration::class)->findAllNotHistorized($this->getUser());
//        $secteurs = $mgr->getRepository(Secteur::class)->findAll();
//
//        $form = $this->createForm(SearchFormType::class, null, [
//            'action' => $this->generateUrl('main_home'),
//            'method' => 'GET',
//        ]);
////
//        $form->handleRequest($req);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $search = $form->getData();
//            $declarations = $mgr->getRepository(Declaration::class)->filters($search, $this->getUser());
//        }
//
//        //Pagination des declarations :
//        $declarationsToDisplay = $paginator->paginate($declarations, $req->query->getInt('page', 1), 6);
//
//        return $this->render('main/accueil.html.twig', [
//            'controller_name' => 'MainController',
//            'declarations' => $declarationsToDisplay,
//            'secteur' => $secteurs,
//            'formS' => $form->createView(),
//        ]);
//    }


}