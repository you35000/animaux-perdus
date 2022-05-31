<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface {
    /*
     * Utilise la méthode avant l'authentification de l'utilisateur afin de le bloquer, via l'appel de l'exception
     * CustomUserMessageAccountException, l'informant que son compte est suspendu
     *
     * Seul la vérification pre-authentification étant nécessaire, aucun code n'est présent dans l'autre fonction
     */
    public function checkPreAuth(UserInterface $user)
    {
        // On s'assure que l'utilisateur est une instance de la class User
        if (!$user instanceof User) {
            return;
        }

        // Si le compte de l'utilisateur n'est pas actif, on bloque le processus de connexion, et on affiche un message
        if (!$user->getIsActive()) {
            throw new CustomUserMessageAccountStatusException("Votre compte est suspendu");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
    }
}