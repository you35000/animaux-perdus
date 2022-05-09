<?php

namespace App\Form;



use App\Entity\Declaration;
use App\Entity\EspeceAnimal;
use App\Entity\Etat;
use App\Entity\Secteur;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'libelle',
                'label'=>'Etat : ',
                'required' => false,
            ])

            ->add('typeAnimal', EntityType::class, [
                'class'=>EspeceAnimal::class,
                'choice_label'=>'libelle',
                'label'=>'Espèce animal ',
            ])

            ->add('secteur', EntityType::class, [
                'class'=>Secteur::class,
                'choice_label'=>'libelle',
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
