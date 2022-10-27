<?php

namespace App\Repository;

use App\Entity\NiFormejuridique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiFormejuridique|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiFormejuridique|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiFormejuridique[]    findAll()
 * @method NiFormejuridique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiFormejuridiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiFormejuridique::class);
    }

    // /**
    //  * @return NiFormejuridique[] Returns an array of NiFormejuridique objects
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
    public function findOneBySomeField($value): ?NiFormejuridique
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
