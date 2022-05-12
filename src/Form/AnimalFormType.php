<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom Animal',
                'trim' => true,
                'required' => true
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                      'Je ne sais pas' => 1,
                      'Male' => 2,
                      'Femelle' => 3,
                    ]
            ])
            ->add('castre', ChoiceType::class, [
                'label' => 'Castré',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Oui' => 2,
                    'Non' => 3,
                ]
            ])
            ->add('croisement', ChoiceType::class, [
                'label' => 'Croisement',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Croisé' => 2,
                    'Pure race' => 3,
                ]
            ])
            ->add('puceElectro', ChoiceType::class, [
                'label' => 'Puce éléctronique',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Oui' => 2,
                    'Non' => 3,
                ]
            ])
            ->add('tatouage', ChoiceType::class, [
                'label' => 'Tatouage',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Oui' => 2,
                    'Non' => 3,
                ]
            ])
            ->add('collier', ChoiceType::class, [
                'label' => 'Collier',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Oui' => 2,
                    'Non' => 3,
                ]
            ])
            ->add('typeCollier', ChoiceType::class, [
                'label' => 'Type collier',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Chainette' => 2,
                    'Cuir' =>3,
                    'Nylon' => 4,
                    'Plastique' =>5,
                ]
            ])
            ->add('silhouette', ChoiceType::class, [
                'label' => 'Silhouette',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Maigre' => 2,
                    'Normale' => 3,
                    'Dodue' => 4,
                ]
            ])
            ->add('taille', ChoiceType::class, [
                'label' => 'Taille',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Petite' => 2,
                    'Moyenne' => 3,
                    'Grande' => 4,
                ]
            ])
            ->add('poils', ChoiceType::class, [
                'label' => 'Poils',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'Courts' => 2,
                    'Longs' => 3,
                    'Mi-longs' => 4,
                    'Raides' => 5,
                    'Frisés' => 6,
                ]
            ])
            ->add('age', NumberType::class, [
                'label' => 'Age',
                'trim' => true,
                'required' => true,
            ])
            ->add('anOuMois', ChoiceType::class, [
                'label' => 'An ou Mois',
                'choices' => [
                    'Je ne sais pas' => 1,
                    'An' => 2,
                    'Mois' => 3,
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
