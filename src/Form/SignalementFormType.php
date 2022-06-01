<?php

namespace App\Form;

use App\Entity\Signalement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignalementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeure', DateTimeType::class, [
                'label' => 'Date et heure',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
//                'data' => (new \DateTime())->modify('+1 day'),
            ])
            ->add('message', TextareaType::class, [
                'label' => 'message',
//                'attr' => ['placeholder' => 'message'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Signalement::class,
        ]);
    }
}
