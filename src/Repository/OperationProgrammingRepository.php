<?php

namespace App\Repository;

use App\Entity\OperationProgramming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperationProgramming|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationProgramming|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationProgramming[]    findAll()
 * @method OperationProgramming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationProgrammingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationProgramming::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OperationProgramming $entity, bool $flush = true): void
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
    public function remove(OperationProgramming $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return OperationProgramming[] Returns an array of OperationProgramming objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperationProgramming
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
