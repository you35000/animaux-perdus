<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Declaration;
use App\Entity\Secteur;
use App\Model\SearchDeclaration;
use App\Repository\CommuneRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotNull;

class SearchDeclarationFormType extends AbstractType
{
       public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeureD', DateTimeType::class, [
                'label' => 'Date et heure de la disparition',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false
            ])


            ->add('secteurs', EntityType::class, [
                'class'=> Secteur::class,
                'label' => 'Secteur géographique',
                'choice_label' => 'nom',
                'required' => false,
                'attr' => ['placeholder' => 'Secteur géographique']
            ])
            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'required' => false,
                'label' => 'Commune/Ville',
                'placeholder' => 'Choisissez une commune/ville',
                'choice_label' => 'nom'
            ])
        ;


    }

    //à redéfinir pour imposer un nom pour le form
    public function getBlockPrefix()
    {
        return "searchDeclaration";
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchDeclaration::class,
        ]);
    }
}
