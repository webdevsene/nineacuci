<?php

namespace App\Repository;

use App\Entity\NAEMA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NAEMA|null find($id, $lockMode = null, $lockVersion = null)
 * @method NAEMA|null findOneBy(array $criteria, array $orderBy = null)
 * @method NAEMA[]    findAll()
 * @method NAEMA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NAEMARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NAEMA::class);
    }

    // /**
    //  * @return NAEMA[] Returns an array of NAEMA objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NAEMA
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
