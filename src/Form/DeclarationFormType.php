<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Declaration;
use App\Entity\Secteur;
use App\EventSubscriber\SecteurSubscriber;
use App\Repository\CommuneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class DeclarationFormType extends AbstractType
{
//    private Security $security;
    private SecteurSubscriber $secteurSubscriber;
    private EntityManagerInterface $entityManager;
    private CommuneRepository $communeRepository;
//Security $security,
    public function __construct(SecteurSubscriber $secteurSubscriber,
                                CommuneRepository $communeRepository,
                                EntityManagerInterface $entityManager)
    {
//        $this->security = $security;
        $this->secteurSubscriber = $secteurSubscriber;
        $this->communeRepository = $communeRepository;
        $this->entityManager = $entityManager;
    }


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
                'attr' => ['placeholder' => 'infos supplémentaires']
            ])

            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'mapped' => false,
                'label' => 'Commune',
                'placeholder' => 'Choisissez une commune/ville',
                'choice_label' => 'nom',
                'query_builder' => function(CommuneRepository $communeRepository){
                    return $communeRepository->createQueryBuilder('c')->addOrderBy('c.nom', 'ASC');
                },
                'constraints' => [
                    new NotNull(
                        [], "Veuillez choisir une commune/ville")
                ]
            ])

            ->add('secteurs', EntityType::class, [
                'label' => 'Secteur',
                'placeholder' => 'Secteur géographique',
                'choices' => [],
                'choice_label' => 'nom',
                'class'=> Secteur::class
            ])
        ;

        //étant donné que je ne charge aucun secteur à l'affichage du form, je rajoute un évènement preSubmit
        // pour charger des secteurs en fonction de la commune

        //Utilisation d'une class subscriber
        //$builder->addEventSubscriber($this->secteurSubscriber);

        //utilisation d'un listener
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
    }

    public function getCommunes(){
        return $this->communeRepository->createQueryBuilder('c')->addOrderBy('c.nom', 'DESC');
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
            'label' => 'secteur',
            'placeholder' => 'Choisir le secteur',
            'choices' => $secteurs,
            'choice_label' => 'nom',
            'class' => Secteur::class
        ]);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Declaration::class,
        ]);
    }
}
