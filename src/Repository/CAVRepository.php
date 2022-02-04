<?php

namespace App\Repository;

use App\Entity\CAV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CAV|null find($id, $lockMode = null, $lockVersion = null)
 * @method CAV|null findOneBy(array $criteria, array $orderBy = null)
 * @method CAV[]    findAll()
 * @method CAV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CAVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CAV::class);
    }

    // /**
    //  * @return CAV[] Returns an array of CAV objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CAV
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
