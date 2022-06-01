<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Declaration;
use App\Entity\EspeceAnimal;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

//            ->add('animaux', EntityType::class, [
//                'class'=>Animal::class,
//                'choice_label'=>'animaux',
//                'label'=>'Espèce animal ',
//            ])

            ->add('secteurs', EntityType::class, [
                'class'=>Secteur::class,
                'choice_label'=>'nom',
                'label'=>'Secteur : ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' =>Declaration::class,
        ]);
    }
}
