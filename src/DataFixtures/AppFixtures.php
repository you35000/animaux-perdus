<?php

namespace App\DataFixtures;


use App\Entity\Commune;
use App\Entity\Couleur;
use App\Entity\Departement;
use App\Entity\EspeceAnimal;
use App\Entity\Etat;
use App\Entity\Race;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
class AppFixtures extends Fixture
{

    private ObjectManager $manager;

    public function __construct(UserPasswordHasherInterface $passwordHasher)

    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        //$this->addUser();
//        $this->addEtat();
//                    $this->addDeclaration();
//                    $this->addSecteur();
//                    $this->addCommune();
//        $this->addDepartement();
//                    $this->addAnimal();
//        $this->addCouleur();
//
      $this->addEspeceAnimal();
        $this->addRace();

    }

    public function addUser()
    {
        $user = new User();
        $user->setPseudo('jiji')
            ->setNom('Dupont')
            ->setPrenom('Jean')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setEmail('jean.dupont@gmail.com')
            ->setTelephone($this->faker->mobileNumber)
            ->setPassword($this->hasher->hashPassword($user, '123'));

        $this->manager->persist($user);


        for ($i = 0; $i < 50; $i++) {
            $prenom = $this->faker->firstName;
            $nom = $this->faker->lastName;
            $pseudo = $prenom . ' ' . substr($nom, 0, 1) . '.';
//            $email = strtolower($fname).'.'.strtolower($lname).'@free.fr';
            $user = new User();
            $user->setPrenom($prenom)
                ->setNom($nom)
                ->setPseudo($pseudo)
                ->setRoles(['ROLE_USER'])
                ->setEmail($this->faker->freeEmail)
                ->setTelephone($this->faker->mobileNumber)
                ->setPassword($this->hasher->hashPassword($user, '123456'));

            $this->manager->persist($user);
        }
        $this->manager->flush();
    }

    public function addEtat()
    {
        $etat = new Etat();
        $etat->setLibelle('Recherche en cours');
        $this->manager->persist($etat);

        $etat = new Etat();
        $etat->setLibelle('Recherche abondonnée');
        $this->manager->persist($etat);

        $etat = new Etat();
        $etat->setLibelle('Trouvé');
        $this->manager->persist($etat);

        $this->manager->flush();
    }



    public function addDepartement()
    {
        $faker = Factory::create('fr_FR');
            $dep= new Departement();
        $dep->setNom('Ille-et-Vilaine');
        $dep->setNumero('35');
            $this->manager->persist($dep);

        $dep= new Departement();
        $dep->setNom('Finistère ');
        $dep->setNumero('29');
            $this->manager->persist($dep);

        $dep= new Departement();
        $dep->setNom('Morbihan ');
        $dep->setNumero('56');
            $this->manager->persist($dep);

        $dep= new Departement();
        $dep->setNom('Côtes-d Armor');
        $dep->setNumero('22');
            $this->manager->persist($dep);

        $this->manager->flush();
    }



    public function addEspeceAnimal()
    {
        $especeAnimal = new EspeceAnimal();
        $especeAnimal->setLibelle('Chien');
//        $especeAnimal->setId('1');
        $this->manager->persist($especeAnimal);

        $especeAnimal = new EspeceAnimal();
        $especeAnimal->setLibelle('Chat');
//        $especeAnimal->setId('2');
        $this->manager->persist($especeAnimal);

        $this->manager->flush();
    }

    public function addCouleur()
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {

            $Couleur= new Couleur();
            $Couleur->setLibelle($this->faker->colorName);
                $this->manager->persist($Couleur);
        }
        $this->manager->flush();
    }

    public function addRace()
    {


        $faker = Factory::create('fr_FR');
        $especes = $this-> manager->getRepository(EspeceAnimal::class)->findAll();


        $race= new Race();
        $race->setNom('Affenpinscher');
        $race->setEspeces ($especes[0]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Airedale Terrier ');
        $race->setEspeces($especes[0]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Akita Américain ');
        $race->setEspeces($especes[0]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Staffordshire Terrier');
        $race->setEspeces($especes[0]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Ancien chien d arrêt danois');
        $race->setEspeces($especes[0]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Bobtail à poil long');
        $race->setEspeces($especes[1]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Bobtail à poil court ');
        $race->setEspeces($especes[1]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Abyssin ');
        $race->setEspeces($especes[1]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Curl à poil long');
        $race->setEspeces($especes[1]);
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Burmese Américain');
        $race->setEspeces($especes[1]);
        $this->manager->persist($race);

        $this->manager->flush();
    }

//    public function addCommune()
//    {
//        $faker = Factory::create('fr_FR');
//        $departement = $this->manager->getRepository(Departement::class)->findAll();
//        for ($i = 0; $i < 20; $i++) {
//
//            $commune= new Commune();
//            $commune->setNom($this->faker->city)
//                ->setCodepostal($this->faker->postcode)
//                -> $this->setDepartements_id($this->faker->randomElement($departement));
//            $this->manager->persist($commune);
//        }
//        $this->manager->flush();
//    }
}
