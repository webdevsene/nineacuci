<?php

namespace App\Repository;

use App\Entity\NiAdministration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiAdministration|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiAdministration|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiAdministration[]    findAll()
 * @method NiAdministration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiAdministrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiAdministration::class);
    }

    // /**
    //  * @return NiAdministration[] Returns an array of NiAdministration objects
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
    public function findOneBySomeField($value): ?NiAdministration
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
