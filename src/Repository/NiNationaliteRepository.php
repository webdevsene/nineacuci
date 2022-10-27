<?php

namespace App\Repository;

use App\Entity\NiNationalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiNationalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiNationalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiNationalite[]    findAll()
 * @method NiNationalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiNationaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiNationalite::class);
    }

    // /**
    //  * @return NiNationalite[] Returns an array of NiNationalite objects
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
    public function findOneBySomeField($value): ?NiNationalite
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
