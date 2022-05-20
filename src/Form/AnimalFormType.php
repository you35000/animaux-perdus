<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Couleur;
use App\Entity\Croisement;
use App\Entity\EspeceAnimal;
use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\Silhouette;
use App\Entity\Taille;
use App\Entity\TypeCollier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\File;

class AnimalFormType extends AbstractType
{
    private $em;

    /***
     * @param EntityManagerInterface $em
     *
     */
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//       $races = $this->em->getRepository(Race::class)->findAll();
        $yesOrNo = [
            'Oui' => 1,
            'Non' => 0
        ];

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom Animal :',

                'trim' => true,
                'required' => true
            ])

            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe :',
                'placeholder' => 'Selectionnez le sexe',
                'choices' => [
                    'Male' => true,
                    'Femelle' => false,
                ]
            ])

            ->add('castre', ChoiceType::class, [
                'label' => 'Castré :',
                'placeholder' => 'Est-il castré ?',
                'choices' => $yesOrNo
            ])

            ->add('croisements', EntityType::class, [
                'label' => 'Croisement :',
                'placeholder' => 'L\'animal est t-il croisé ?',
                'class' => Croisement::class,
                'choice_label' => 'libelle'

            ])
            ->add('puceElectro', ChoiceType::class, [
                'label' => 'Puce éléctronique :',
                'choices' => $yesOrNo,
                'placeholder' => 'Est-il pucé ?'
            ])
            ->add('tatouage', ChoiceType::class, [
                'label' => 'Tatouage :',
                'choices' => $yesOrNo,
                'placeholder' => 'Est-il tatoué ?'
            ])
            ->add('collier', ChoiceType::class, [
                'label' => 'Collier :',
                'choices' => $yesOrNo,
                'placeholder' => 'L\'animal a t-il un collier ?'
            ])
            ->add('typeColliers', EntityType::class, [
                'label' => 'Type collier : ',
                'placeholder' => 'Selectionnez la type de collier',
                'class' => TypeCollier::class,
                'choice_label' => 'libelle'
            ])
            ->add('silhouette', EntityType::class, [
                'class' => Silhouette::class,
                'label' => 'Silhouette :',
                'placeholder' => 'Selectionnez la silhouette',
                'choice_label' => 'libelle'

            ])
            ->add('taille', EntityType::class, [
                'label' => 'Taille :',
                'placeholder' => 'Selectionnez la taille',
                'class' => Taille::class,
                'choice_label' => 'libelle'
            ])
            ->add('poils', EntityType::class, [
                'label' => 'Poils :',
                'placeholder' => 'Selectionnez le type de plois',
                'class' => Poil::class,
                'choice_label' => 'libelle'
            ])
            ->add('age', NumberType::class, [
                'label' => 'Age :',
                'trim' => true,
                'required' => true,
            ])
            ->add('anOuMois', ChoiceType::class, [
                'label' => 'An ou Mois :',
                'choices' => [
                    'placeholder' => 'Selectionnez le type d\'âge',
                    'An(s)' => true,
                    'Mois' => false,
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
            ])

            ->add('couleurs', EntityType::class, [
                'placeholder' => 'Selectionnez la couleur',
                'label' => 'Couleur : ',
                'class' => Couleur::class,
                'choice_label' => 'libelle'
            ]);

//            ->add('races', EntityType::class, [
//                'class' => Race::class,
//                'mapped' => false,
//                'label' => 'Race : ',
//                'placeholder' => 'Selectionnez la race ...',
////                'choices' => $races
//            ])
//
//            ->add('especes', EntityType::class, [
////                'choices' => $especes,
//                'placeholder' => 'Selectionnez l\'éspèce ...',
//                'class' => EspeceAnimal::class,
//                'mapped' => false,
//                'label' => 'Espèce animal : ',
////                'choice_label' => 'libelle'
//
//            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, EspeceAnimal $especeAnimal = null) {
        // 4. Add the province element
        $form->add('especes', EntityType::class, array(
            'mapped' => false,
            'required' => true,
            'data' => $especeAnimal,
            'placeholder' => 'Selectionnez une éspèce',
            'class' => EspeceAnimal::class
        ));

        $races = array();

        if ($especeAnimal) {

            $repoRaces = $this->em->getRepository(Race::class);
            $races = $repoRaces->createQueryBuilder("r")
                ->where("r.especes = :id")
                ->setParameter("id", $especeAnimal->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the Neighborhoods field with the properly data
        $form->add('races', EntityType::class, [
            'required' => true,
            'placeholder' => "Veuillez d'abord choisir une éspèce ...",
            'class' => Race::class,
            'choices' => $races
        ]);
    }
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        $especes = $this->em->getRepository(EspeceAnimal::class)->find($data['especes']);
        $this->addElements($form, $especes);
    }
    function onPreSetData(FormEvent $event) {
        $person = $event->getData();
        $form = $event->getForm();


        $espece = null;
        $this->addElements($form, $espece);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
