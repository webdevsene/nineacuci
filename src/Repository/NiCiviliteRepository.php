<?php

namespace App\Repository;

use App\Entity\NiCivilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiCivilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiCivilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiCivilite[]    findAll()
 * @method NiCivilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiCiviliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiCivilite::class);
    }

    // /**
    //  * @return NiCivilite[] Returns an array of NiCivilite objects
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
    public function findOneBySomeField($value): ?NiCivilite
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
