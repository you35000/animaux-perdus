<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/internal")
 */

class UserController extends AbstractController
{
//    private EntityManagerInterface $entityManager;
//
//    public function __construct(
//        EntityManagerInterface $entityManager
//    )
//    {
//        $this->entityManager = $entityManager;
//    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

//* @Route("/user/{id}/edit", name="user_edit", methods={"GET", "POST"})
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/{id}/edit", name="user_edit")
     */
    public function edit(EntityManagerInterface $entityManager, Request $request,  SluggerInterface $slugger, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $form->get('password')->getData();
            if ($password){
                $hashedPassword = $hasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }
            $picture = $form->get('photo')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                try {
                    $picture->move(
                        $this->getParameter('uploads_user_pictures'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd('oups : prob\'s happened');
                }

                $user->setPhoto($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->redirectToRoute('main_home');

//            $userRepository->add($user);
//            return $this->redirectToRoute('app_utilisateurs', [], Response::HTTP_SEE_OTHER);
        }
//
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
    }
}
