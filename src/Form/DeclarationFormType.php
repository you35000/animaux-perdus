<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Commune;
use App\Entity\Declaration;
use App\Entity\Secteur;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeclarationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeureD', DateTimeType::class, [
                'label' => 'Date et heure de la disparition',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
//                'data' => (new \DateTime())->modify('+1 day'),
            ])
            ->add('infoSupp', TextareaType::class, [
                'label' => 'infos supplémentaires',
                'attr' => ['placeholder' => 'infos supplémentaires'],
            ])
            ->add('secteurs', EntityType::class, [
                'class'=> Secteur::class,
                'label' => 'Secteur géographique',
//                'trim' => true,
                'attr' => ['placeholder' => 'Secteur géographique'],
            ])
            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'mapped' => false,
                'required' => true,
                'label' => 'Commune/Ville',
                'placeholder' => 'Choisissez une commune/ville',
                'choice_label' => 'nom',
            ])
//            ->add('animaux', EntityType::class, [
//                'class' => Animal::class,
//                'label' => 'Animal : ',
//                'choice_label' => 'nom'
//            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Declaration::class,
        ]);
    }
}
