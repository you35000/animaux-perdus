<?php

namespace App\DataFixtures;


use App\Entity\Animal;
use App\Entity\Commune;
use App\Entity\Couleur;
use App\Entity\Declaration;
use App\Entity\Departement;
use App\Entity\EspeceAnimal;
use App\Entity\Etat;
use App\Entity\Race;
use App\Entity\Secteur;
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
//        $this->addUser();
//        $this->addEtat();
//        $this->addDepartement();
//        $this->addCommune();
//        $this->addSecteur();
//        $this->addCouleur();
//        $this->addEspeceAnimal();
//        $this->addRace();
        $this->addAnimal();
        //$this->addDeclaration();
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

        $etat = new Etat();
        $etat->setLibelle('Archivée');
        $this->manager->persist($etat);

        $this->manager->flush();
    }

    public function addEspeceAnimal()
    {
        $especeAnimal = new EspeceAnimal();
        $especeAnimal->setLibelle('Chien');
        $especeAnimal->setCodeAnimal('DO');
        $this->manager->persist($especeAnimal);

        $especeAnimal = new EspeceAnimal();
        $especeAnimal->setLibelle('Chat');
        $especeAnimal->setCodeAnimal('CA');
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


    public function addDepartement()
    {
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

    public function addCommune()
    {
        $faker = Factory::create('fr_FR');
        $departement = $this->manager->getRepository(Departement::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $city = $this->faker->city;
            $postcode = $this->faker->postcode;
            $commune= new Commune();
            $commune->setNom($city)
                ->setCodepostal($postcode)
                ->setDepartements($this->faker->randomElement($departement));
            $this->manager->persist($commune);
        }
        $this->manager->flush();
    }

    public function addSecteur()
    {
        $faker = Factory::create('fr_FR');
        $commune = $this->manager->getRepository(Commune::class)->findAll();
        $secteurs = ['Gare sud','Gare Nord','Centre','Est','Ouest','Blose','Republique','St Anne','Université','LeMarché'];
        for ($i = 0; $i < 20; $i++) {

            $secteur= new Secteur();
            $secteur->setNom($this->faker->randomElement($secteurs))
                   ->setAdresse($this->faker->streetAddress)
                   ->setCommunes($this->faker->randomElement($commune))
                   ->setLongitude($this->faker->longitude)
                   ->setLatitude($this->faker->latitude);
            $this->manager->persist($secteur);
        }
        $this->manager->flush();
    }


    public function addAnimal()
    {
        $faker = Factory::create('fr_FR');
        $espece = $this->manager->getRepository(EspeceAnimal::class)->findAll();
        $race = $this->manager->getRepository(Race::class)->findAll();
        $couleur = $this->manager->getRepository(Couleur::class)->findAll();
        $nom = ['AA','BB','CC','DD','EE','FF','GG','HH','KK','LL','MM','NN','OO','PP','QQ','SS','RR','SS','ZZ','YY','VV','JJ','UU','XX','WW'];
        $croisement = [1,2,3];
        $sexe = [1,2,3];
        $castre = [1,2,3];
        $puce = [1,2,3];
        $tatouage = [1,2,3];
        $collier = [1];
        $typeCollier = [1,2,3,4,5];
        $silhouette = [1,2,3,4];
        $taille = [1,2,3,4];
        $polis = [1,2,3,4,5,6];
        $age = [5,8];
        $anOuMois = [1,2];

        for ($i = 0; $i < 20; $i++) {
            $animal = new Animal();
            $animal ->setRaces($faker->randomElement($race))

                ->setNom($faker->randomElement($nom))
                ->setSexe($faker->randomElement($sexe))
                ->setCastre($faker->randomElement($castre))
                ->setCroisement($faker->randomElement($croisement))
                ->setPuceElectro($faker->randomElement($puce))
                ->setTatouage($faker->randomElement($tatouage))
                ->setCollier($faker->randomElement($collier))
                ->setTypeCollier($faker->randomElement($typeCollier))
                ->setSilhouette($faker->randomElement($silhouette))
                ->setTaille($faker->randomElement($taille))
                ->setPoils($faker->randomElement($polis))
                ->setAge($faker->randomElement($age))
                ->setAnOuMois($faker->randomElement($anOuMois))
                ->setCouleurs($faker->randomElement($couleur));
//            if ($espece->codeAnimal == 'DO'){
                $animal->setEspeces($this->faker->randomElement($race));
//            }
                $this->manager->persist($animal);
        }

                $this->manager->flush();
    }





    public function addDeclaration()
    {
        $faker = Factory::create('fr_FR');
        $etats = $this->manager->getRepository(Etat::class)->findAll();
//        $users = $this->manager->getRepository(User::class)->findAll();
        $secteurs = $this->manager->getRepository(Secteur::class)->findAll();


        for ($i = 0; $i < 50; $i++) {

            $dateHeure = $faker->dateTimeThisYear();
            $declaration = new Departement();
            $declaration->setSecteurs($this->faker->randomElement($secteurs))
            ->setDateHeureDipar(date_add($dateHeure, date_interval_create_from_date_string('9 months')))
                ->setUsers($faker->randomElement($this->manager->getRepository(User::class)->findAll()))
                ->setEtats($faker->randomElement($etats));

            $this->manager->persist($declaration);
        }

        $this->manager->flush();
    }
}
