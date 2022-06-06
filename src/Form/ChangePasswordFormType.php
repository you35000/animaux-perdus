<?php

namespace App\Form;

use App\Model\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class,[
                'label' => 'Ancien mot de passe : ',
                ])

                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'mapped' => false,
                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                    'required' => false,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmation'],
                    'constraints'=> [
                        new NotBlank(['message' => 'Veuillez saisir un mot de passe',]),
                        new Length([
                            'min' => 6,
                            'minMessage'=>'le mot de passe doit contenir au moins 6 caractères',
                            'max' =>16,
                            'maxMessage'=>'le mot de passe doit contenir au moins 6 caractères',

                        ]),
                        new Regex([
                            'pattern' => "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ !\"\#\$%&\'\(\)*+,\-.\/:;<=>?@[\\^\]_`\{|\}~])^.{0,4096}$/",
                            'message' => 'Le mot de passe doit contenir obligatoirement une minuscule, une majuscule, un chiffre et un caractère spécial.',
                            ])
                    ],


                ]);

    }

//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//
//        ]);
//    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            //mettre le nouveau formulaire
            'data_class' => ChangePassword::class,
            'csrf_token_id' => 'change_password',
        ));
    }
}
