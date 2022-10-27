<?php

namespace App\Repository;

use App\Entity\AchatProductionUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AchatProductionUtil|null find($id, $lockMode = null, $lockVersion = null)
 * @method AchatProductionUtil|null findOneBy(array $criteria, array $orderBy = null)
 * @method AchatProductionUtil[]    findAll()
 * @method AchatProductionUtil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AchatProductionUtilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AchatProductionUtil::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AchatProductionUtil $entity, bool $flush = true): void
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
    public function remove(AchatProductionUtil $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return AchatProductionUtil[] Returns an array of AchatProductionUtil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AchatProductionUtil
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
