<?php

namespace App\Repository;

use App\Entity\NiPersonnemorale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiPersonnemorale|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiPersonnemorale|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiPersonnemorale[]    findAll()
 * @method NiPersonnemorale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiPersonnemoraleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiPersonnemorale::class);
    }

    // /**
    //  * @return NiPersonnemorale[] Returns an array of NiPersonnemorale objects
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
    public function findOneBySomeField($value): ?NiPersonnemorale
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
