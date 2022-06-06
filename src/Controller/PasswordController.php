<?php
namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Model\ChangePassword;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/internal")
 */

class PasswordController extends AbstractController {

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/{id}/change-password", name="change_password")
     */
    public function edit(EntityManagerInterface $entityManager,Request $request,  UserPasswordHasherInterface $hasher) {
        $this->denyAccessUnlessGranted('ROLE_USER');
//        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $changePassword = new ChangePassword();
        // rattachement du formulaire avec la class changePassword
//        $form = $this->createForm('App/Form/ChangePasswordFormType', $changePassword);
        $form = $this->createForm(ChangePasswordFormType::class,$changePassword);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

//            $newpwd = $form->get('password')['first']->getData();
            $newpwd = $form->get('password')->getData();

            if ($newpwd) {
                $newHashedPassword = $hasher->hashPassword($user, $newpwd);
                $user->setPassword($newHashedPassword);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('main_home');
        }

        return $this->render('user/changePassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

}