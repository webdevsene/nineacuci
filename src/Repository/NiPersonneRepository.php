<?php

namespace App\Repository;

use App\Entity\NiPersonne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiPersonne|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiPersonne|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiPersonne[]    findAll()
 * @method NiPersonne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiPersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiPersonne::class);
    }

    // /**
    //  * @return NiPersonne[] Returns an array of NiPersonne objects
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
    public function findOneBySomeField($value): ?NiPersonne
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
