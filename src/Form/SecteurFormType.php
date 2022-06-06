<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Secteur;
use App\Repository\CommuneRepository;
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
            ->add('codePostal', null, [
                'mapped' => false
            ])
            ->add('adresse')
            ->add('latitude')
            ->add('longitude')

            ->add('communes', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Commune::class,
//                'required' => true,
//                'label' => 'Commune',
//                'placeholder' => 'Choisissez une commune',
                'query_builder' => function(CommuneRepository $communeRepository){
                    return $communeRepository->createQueryBuilder('c')->addOrderBy('c.nom', 'ASC');
                }

            ])
            ->add('nom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteur::class,
        ]);
    }
}
