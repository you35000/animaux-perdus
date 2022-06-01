<?php

namespace App\DataFixtures;


use App\Entity\Animal;
use App\Entity\Commune;
use App\Entity\Couleur;
use App\Entity\Croisement;
use App\Entity\Declaration;
use App\Entity\Departement;
use App\Entity\EspeceAnimal;
use App\Entity\Etat;
use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\Secteur;
use App\Entity\Signalement;
use App\Entity\Silhouette;
use App\Entity\Taille;
use App\Entity\TypeCollier;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
//use mysql_xdevapi\Table;
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
        $this->addUser();
        $this->addCroisement();
        $this->addSilhouette();
        $this->addTaille();
        $this->addEtat();
        $this->addPoil();
        $this->addTypeCollier();
        $this->addDepartement();
        $this->addCommune();
        $this->addSecteur();
        $this->addEspeceAnimal();
        $this->addCouleur();
        $this->addRace();
        $this->addAnimal();
        $this->addDeclaration();
        $this->addSignalement();
//        $this->addCommentaire();
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
            ->setPassword($this->hasher->hashPassword($user, '123'))
            ->setIsActive(1);

        $this->manager->persist($user);


        for ($i = 0; $i < 20; $i++) {
            $prenom = $this->faker->firstName;
            $nom = $this->faker->lastName;
            $pseudo = $prenom . ' ' . substr($nom, 0, 1) . '.';
//            $email = strtolower($fname).'.'.strtolower($lname).'@free.fr';
            $user = new User();
            $user->setPrenom($prenom)
                ->setNom($nom)
                ->setPseudo($pseudo)
                ->setRoles(['ROLE_USER'])
                ->setIsActive(1)
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
        $etat->setLibelle('crée');
        $this->manager->persist($etat);

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

    public function addSilhouette()
    {
        $silhouette = new Silhouette();
        $silhouette->setLibelle('Maigre');
        $this->manager->persist($silhouette);

        $silhouette = new Silhouette();
        $silhouette->setLibelle('Normale');
        $this->manager->persist($silhouette);

        $silhouette = new Silhouette();
        $silhouette->setLibelle('Dodue');
        $this->manager->persist($silhouette);

        $this->manager->flush();
    }

    public function addCroisement()
    {
        $croisement = new Croisement();
        $croisement->setLibelle('Pure race');
        $this->manager->persist($croisement);

        $croisement = new Croisement();
        $croisement->setLibelle('Croisé');
        $this->manager->persist($croisement);

        $this->manager->flush();
    }



    public function addTaille()
    {
        $taille = new Taille();
        $taille->setLibelle('Petite');
        $this->manager->persist($taille);

        $taille = new Taille();
        $taille->setLibelle('Moyenne');
        $this->manager->persist($taille);

        $taille = new Taille();
        $taille->setLibelle('Grande');
        $this->manager->persist($taille);

        $this->manager->flush();
    }


    public function addTypeCollier()
    {
        $typeCollier = new TypeCollier();
        $typeCollier->setLibelle('Chainette');
        $this->manager->persist($typeCollier);

        $typeCollier = new TypeCollier();
        $typeCollier->setLibelle('Cuir');
        $this->manager->persist($typeCollier);

        $typeCollier = new TypeCollier();
        $typeCollier->setLibelle('Nylon');
        $this->manager->persist($typeCollier);

        $typeCollier = new TypeCollier();
        $typeCollier->setLibelle('Plastique');
        $this->manager->persist($typeCollier);

        $this->manager->flush();
    }

    public function addPoil()
    {
        $poil = new Poil();
        $poil->setLibelle('Courts');
        $this->manager->persist($poil);

        $poil = new Poil();
        $poil->setLibelle('Longs');
        $this->manager->persist($poil);

        $poil = new Poil();
        $poil->setLibelle('Mi-longs');
        $this->manager->persist($poil);

        $poil = new Poil();
        $poil->setLibelle('Raides');
        $this->manager->persist($poil);

        $poil = new Poil();
        $poil->setLibelle('Frisés');
        $this->manager->persist($poil);

        $this->manager->flush();
    }

    public function addEspeceAnimal()
    {
        $especeAnimal = new EspeceAnimal();
        $especeAnimal->setLibelle('Chien');
//        $especeAnimal->setCode('DO');
        $this->manager->persist($especeAnimal);

        $especeAnimal = new EspeceAnimal();
        $especeAnimal->setLibelle('Chat');
//        $especeAnimal->setCode('CA');
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
        $race->setCode('DO');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Airedale Terrier ');
        $race->setEspeces($especes[0]);
        $race->setCode('DO');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Akita Américain ');
        $race->setEspeces($especes[0]);
        $race->setCode('DO');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Staffordshire Terrier');
        $race->setEspeces($especes[0]);
        $race->setCode('DO');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Ancien chien d arrêt danois');
        $race->setEspeces($especes[0]);
        $race->setCode('DO');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Bobtail à poil long');
        $race->setEspeces($especes[1]);
        $race->setCode('CA');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Bobtail à poil court ');
        $race->setEspeces($especes[1]);
        $race->setCode('CA');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Abyssin ');
        $race->setEspeces($especes[1]);
        $race->setCode('CA');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('American Curl à poil long');
        $race->setEspeces($especes[1]);
        $race->setCode('CA');
        $this->manager->persist($race);

        $race= new Race();
        $race->setNom('Burmese Américain');
        $race->setEspeces($especes[1]);
        $race->setCode('CA');
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
        $secteurs = ['Secteur Nord','Secteur Sud','Centre','Secteur Est','Secteur Ouest'];
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

        $race = $this->manager->getRepository(Race::class)->findAll();
        $couleur = $this->manager->getRepository(Couleur::class)->findAll();
        $typeCollier = $this->manager->getRepository(TypeCollier::class)->findAll();
        $polis = $this->manager->getRepository(Poil::class)->findAll();
        $silhouette = $this->manager->getRepository(Silhouette::class)->findAll();
        $croisement = $this->manager->getRepository(Croisement::class)->findAll();
        $taille = $this->manager->getRepository(Taille::class)->findAll();
        $nom = ['AA','BB','CC','DD','EE','FF','GG','HH','KK','LL','MM','NN','OO','PP','QQ','SS','RR','SS','ZZ','YY','VV','JJ','UU','XX','WW'];
        $sexe = [1,0];
        $castre = [1,0];
        $puce = [1,0];
        $tatouage = [1,0];
        $collier = [1,0];
        $age = [5,8];
        $anOuMois = [1,2];

        for ($i = 0; $i < 10; $i++) {
            $animal = new Animal();
            $animal ->setNom($faker->randomElement($nom))
                ->setSexe($faker->randomElement($sexe))
                ->setCastre($faker->randomElement($castre))
                ->setCroisements($faker->randomElement($croisement))
                ->setPuceElectro($faker->randomElement($puce))
                ->setTatouage($faker->randomElement($tatouage))
                ->setCollier($faker->randomElement($collier))
                ->setTypeColliers($faker->randomElement($typeCollier))
                ->setSilhouettes($faker->randomElement($silhouette))
                ->setTailles($faker->randomElement($taille))
                ->setPoils($faker->randomElement($polis))
                ->setAge($faker->randomElement($age))
                ->setAnOuMois($faker->randomElement($anOuMois))
                ->setCouleurs($faker->randomElement($couleur))
                ->setRaces($faker->randomElement($race));

            $this->manager->persist($animal);
        }

        $this->manager->flush();
    }

    public function addDeclaration()
    {
        $faker = Factory::create('fr_FR');
        $etats = $this->manager->getRepository(Etat::class)->findAll();
        $animaux = $this->manager->getRepository(Animal::class)->findAll();
        $secteurs = $this->manager->getRepository(Secteur::class)->findAll();
        $users = $this->manager->getRepository(User::class)->findAll();

//        (date_add($dateHeure, date_interval_create_from_date_string('9 months')))
        for ($i = 0; $i < 20; $i++) {

            $declaration = new Declaration();
            $declaration->setDateHeureD($this->faker->dateTimeThisYear())
                ->setInfoSupp($this->faker->paragraph)
                ->setUsers($faker->randomElement($users))
                ->setEtats($faker->randomElement($etats))
                ->setAnimaux($faker->randomElement($animaux))
                ->setSecteurs($faker->randomElement($secteurs));
            $this->manager->persist($declaration);
        }

        $this->manager->flush();
    }

    public  function addSignalement(){

        for ($i = 0; $i < 20; $i++) {

            $signalement = new Signalement();
            $signalement->setDateHeure($this->faker->dateTimeThisYear())
                ->setMessage($this->faker->paragraph)
                ->setAuteur($this->faker->firstName);

            $this->manager->persist($signalement);
        }
            $this->manager->flush();

    }
}
