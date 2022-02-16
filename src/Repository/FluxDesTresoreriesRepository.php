<?php

namespace App\Repository;

use App\Entity\FluxDesTresoreries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FluxDesTresoreries|null find($id, $lockMode = null, $lockVersion = null)
 * @method FluxDesTresoreries|null findOneBy(array $criteria, array $orderBy = null)
 * @method FluxDesTresoreries[]    findAll()
 * @method FluxDesTresoreries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FluxDesTresoreriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FluxDesTresoreries::class);
    }

    // /**
    //  * @return FluxDesTresoreries[] Returns an array of FluxDesTresoreries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FluxDesTresoreries
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
