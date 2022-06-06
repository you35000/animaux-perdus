<?php

namespace App\EventSubscriber;

use App\Entity\Commune;
use App\Entity\Secteur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SecteurSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        //récupération de l'instance de la commune en fonction de son id
        $commune = $this->entityManager->getRepository(Commune::class)->find($data['commune']);

        $secteurs = [];

        if($commune){
            //récupération de secteurs par rapport à la commune
            $secteurs = $this->entityManager->getRepository(Secteur::class)->findBy(['communes' => $data['commune']]);
        }

        //rédéfinition de l'élément de mon formulaire, avec les données récupérées
        $form->add('secteurs', EntityType::class, [
            'label' => 'secteurs',
            'placeholder' => 'Choisir un secteur',
            'choices' => $secteurs,
            'choice_label' => 'nom',
            'class' => Secteur::class
        ]);

    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        ];
    }
}
