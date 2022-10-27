<?php

namespace App\Repository;

use App\Entity\NiTypepersone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiTypepersone|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiTypepersone|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiTypepersone[]    findAll()
 * @method NiTypepersone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiTypepersoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiTypepersone::class);
    }

    // /**
    //  * @return NiTypepersone[] Returns an array of NiTypepersone objects
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
    public function findOneBySomeField($value): ?NiTypepersone
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
