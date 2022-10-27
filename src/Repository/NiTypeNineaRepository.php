<?php

namespace App\Repository;

use App\Entity\NiTypeNinea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiTypeNinea|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiTypeNinea|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiTypeNinea[]    findAll()
 * @method NiTypeNinea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiTypeNineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiTypeNinea::class);
    }

    // /**
    //  * @return NiTypeNinea[] Returns an array of NiTypeNinea objects
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
    public function findOneBySomeField($value): ?NiTypeNinea
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
