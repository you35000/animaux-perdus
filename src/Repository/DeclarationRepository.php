<?php

namespace App\Repository;

use App\Entity\Declaration;
use App\Entity\Secteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Declaration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Declaration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Declaration[]    findAll()
 * @method Declaration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Declaration::class);
    }

    public function findDefault(){
        $qb = $this->createQueryBuilder('q');
        $qb->join("q.secteurs", "s");
        $qb->join('q.animaux', "t");
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findByFiltre(Secteur $secteur)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->join("q.secteurs", "s");
//        $qb->join('q.animaux', "t");

        if ($secteur) {
            $qb->setParameter('secteur', $secteur)
                ->andWhere("q.secteurs = :secteur");
        }

//        if ($especeAnimal) {
//            $qb->setParameter('animaux', $especeAnimal)
//                ->andWhere("q.animaux = :animaux");
//        }


        $query = $qb->getQuery();
        return $query->getResult();
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Declaration $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    public function findAllNotHistorized($user)
//    {
//        return $this->createQueryBuilder('o')
//            ->where('o.dateHeureD > :dateNow')
//            ->setParameter('dateNow', new \DateTime())
//            ->andWhere('o.secteurs = :secteur')
//            ->setParameter('secteur', $user->getx())
//            ->orderBy('o.dateHeureD', 'ASC')
//            ->getQuery()->execute();
//    }

//    public function filters(SearchDeclaration $search, User $user)
//    {
//        $qb = $this->createQueryBuilder('o');
//
//        if ($search->getSecteur()) {
//            $qb->andWhere('o.secteurs = :secteur')
//                ->setParameter('secteur', $search->getSecteur());
//        }
//        $qb->orderBy('o.dateHeureD', 'ASC');
//        $query = $qb->getQuery();
//
//        return $query->execute();
//    }

    // /**
    //  * @return Declaration[] Returns an array of Declaration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Declaration
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
