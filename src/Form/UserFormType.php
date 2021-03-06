<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserFormType extends AbstractType
{
//    private RequestStack $requestStack;

//    public function __construct(
//        RequestStack $requestStack
//    ) {
//        $this->requestStack = $requestStack;
//    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'trim' => true,
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'trim' => true,
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'trim' => true,
                'required' => true,
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'trim' => true,
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'trim' => true,
                'required' => true,
            ])

//            if ($this->requestStack->getCurrentRequest()->get('_route') == 'user_new') {
////                dd("Route pour créer un nouvel utilisateur");
//                $builder
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'mapped' => false,

                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                    'required' => false,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmation'],
                    'constraints'=> [
                        new NotBlank(['message' => 'Veuillez saisir un mot de passe',]),
//                        new Length([
//                                   'min' => 8,
//                                   'minMessage' => 'Votre mot de passe doit avoir au moins {{ limit }} caractères',
//                                     // max length allowed by Symfony for security reasons
//                                    'max' => 16,
//                        ]),
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

                    ]
                ])
            ->add('isConsentement',CheckboxType::class,[

                'constraints' => [
//                    'trim' => true,
                    new NotBlank(['message' => ' ',]),
                    new IsTrue(['message' => 'Avez-vu lu notre politique de traitement de données ?'])
                ],
//                'mapped' => false, // pour ne pas lier le consentement à la base de données
                'required' => true,
                'label' => 'J\'accepte les conditions générales d\'utilisation #(CGU)# d\'Animaux-perdu.'
            ])
//            }

//            $builder
            ->add('photo', FileType::class, [
                'label' => 'Ma photo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'L\'extension de cette image est incorrect',
                        'maxSizeMessage' => 'L\'image est trop volumineuse, veuillez sélectionner une autre image'
                    ])
                ],
                'help' => 'Fichiers .png, .jpg, .jpeg acceptés. 1024k max',
                'data_class' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
