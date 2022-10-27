<?php

namespace App\Repository;

use App\Entity\NiLocaliteAdministrative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiLocaliteAdministrative|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiLocaliteAdministrative|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiLocaliteAdministrative[]    findAll()
 * @method NiLocaliteAdministrative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiLocaliteAdministrativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiLocaliteAdministrative::class);
    }

    // /**
    //  * @return NiLocaliteAdministrative[] Returns an array of NiLocaliteAdministrative objects
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
    public function findOneBySomeField($value): ?NiLocaliteAdministrative
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
