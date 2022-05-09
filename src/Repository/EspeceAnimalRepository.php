<?php

namespace App\Repository;

use App\Entity\EspeceAnimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EspeceAnimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method EspeceAnimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method EspeceAnimal[]    findAll()
 * @method EspeceAnimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspeceAnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EspeceAnimal::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EspeceAnimal $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(EspeceAnimal $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EspeceAnimal[] Returns an array of EspeceAnimal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EspeceAnimal
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
