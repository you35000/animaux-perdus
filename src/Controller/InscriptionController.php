<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\UserFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class InscriptionController extends AbstractController
{
    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
                              SluggerInterface $slugger,
                             UserAuthenticatorInterface $userAuthenticator,
                             LoginFormAuthenticator $authenticator,
                             EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_USER']);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            if ($password) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
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


            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
//                return $userAuthenticator->authenticateUser($user, $authenticator, $request);


            }
            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }


    }
