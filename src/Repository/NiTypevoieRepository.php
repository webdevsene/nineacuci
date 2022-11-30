<?php

namespace App\Repository;

use App\Entity\NiTypevoie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiTypevoie|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiTypevoie|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiTypevoie[]    findAll()
 * @method NiTypevoie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiTypevoieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiTypevoie::class);
    }

    // /**
    //  * @return NiTypevoie[] Returns an array of NiTypevoie objects
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
    public function findOneBySomeField($value): ?NiTypevoie
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function filterTypevoies()
    {
        return $this->createQueryBuilder('n')
        ->andWhere('n.id <> 19 and n.id <> 20 and n.id <> 21')
        ->getQuery()
        ->getResult();
    
    }
}
