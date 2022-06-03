<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Commune;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecteurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',])
            ->add('adresse')
            ->add('latitude')
            ->add('longitude')
            ->add('Communes', EntityType::class, [
                'class' => Commune::class,
                'required' => true,
                'label' => 'Commune',
                'placeholder' => 'Choisissez une commune',
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteur::class,
        ]);
    }
}
