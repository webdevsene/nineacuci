<?php

namespace App\Repository;

use App\Entity\NiFormeunite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiFormeunite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiFormeunite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiFormeunite[]    findAll()
 * @method NiFormeunite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiFormeuniteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiFormeunite::class);
    }

    // /**
    //  * @return NiFormeunite[] Returns an array of NiFormeunite objects
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
    public function findOneBySomeField($value): ?NiFormeunite
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
