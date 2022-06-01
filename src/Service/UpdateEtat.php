<?php

namespace App\Service;


use App\Repository\DeclarationRepository;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateEtat
{
    private static ?\dateTimeInterface $lastUpDate = null;
    private DeclarationRepository $declarationRepository;
    private EtatRepository $etatRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(DeclarationRepository $declarationRepository, EtatRepository $etatRepository, EntityManagerInterface $entityManager)
    {
        $this->declarationRepository = $declarationRepository;
        $this->etatRepository = $etatRepository;
        $this->entityManager = $entityManager;
    }

    public function updateDeclaration()
    {
        $declaration = $this->etatRepository->findAllExceptHistorized();
        $etats = $this->etatRepository->findAll();
        foreach ($declaration as $d) {
            $now = new \DateTime();
            $now2 = clone $now;
            $limitDateHistorize = $now2->modify('-2 month');


            if ($d->getDateHeureD() < $limitDateHistorize) { //On marque la déclaration archivé
                $d->setState($etats[4]);
                $this->em->persist($d);
            } elseif ($d->getState()->getLibelle() != 'recherche en cours'
                && $d->getState()->getLibelle() != 'Recherche abondonnée'
                && $d->getDateHeureD() < $now
                && date_add(clone $d->getDateHeureD(),
                    date_interval_create_from_date_string($d->getDuration() . ' minutes')) > $now) { // On marque la recherche est en cours
                $d->setState($etats[2]);
                $this->em->persist($d);
            }
        }
        $this->em->flush();
    }

    /**
     * @param \DateTimeInterface $lastUpdate
     */
    public static function setLastUpdate(\DateTimeInterface $lastUpdate): void
    {
        self::$lastUpDate = $lastUpdate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public static function getLastUpdate(): ?\DateTimeInterface
    {
        return self::$lastUpDate;
    }

}