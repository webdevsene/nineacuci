<?php

namespace App\Repository;

use App\Entity\ImmoBrut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImmoBrut|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImmoBrut|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImmoBrut[]    findAll()
 * @method ImmoBrut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmoBrutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImmoBrut::class);
    }

    // /**
    //  * @return ImmoBrut[] Returns an array of ImmoBrut objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

     public function findByCodeCuci($codeCuci,$annee)
    {
        return $this->createQueryBuilder('i')

            ->innerJoin('i.repertoire','r')
            ->addSelect('r')
            ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('codeCuci', $codeCuci)  
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ImmoBrut
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
