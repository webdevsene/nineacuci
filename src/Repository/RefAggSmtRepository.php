<?php

namespace App\Repository;

use App\Entity\RefAggSmt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefAggSmt>
 *
 * @method RefAggSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefAggSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefAggSmt[]    findAll()
 * @method RefAggSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefAggSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefAggSmt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(RefAggSmt $entity, bool $flush = true): void
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
    public function remove(RefAggSmt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return RefAggSmt[] Returns an array of RefAggSmt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RefAggSmt
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
