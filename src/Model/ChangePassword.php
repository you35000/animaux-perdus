<?php
// src/Form/Model/ChangePassword.php
namespace App\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Mot de passe est incorrect"
     * )
     */

    protected $oldPassword;

    protected $password;


    function getOldPassword() {
        return $this->oldPassword;
    }

    function getNewPssword() {
        return $this->password;
    }

    function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function setNewPassword($password) {
        $this->password = $password;
        return $this;
    }
}
