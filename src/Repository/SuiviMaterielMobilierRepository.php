<?php

namespace App\Repository;

use App\Entity\SuiviMaterielMobilier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuiviMaterielMobilier>
 *
 * @method SuiviMaterielMobilier|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviMaterielMobilier|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviMaterielMobilier[]    findAll()
 * @method SuiviMaterielMobilier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviMaterielMobilierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviMaterielMobilier::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SuiviMaterielMobilier $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(SuiviMaterielMobilier $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return SuiviMaterielMobilier[] Returns an array of SuiviMaterielMobilier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SuiviMaterielMobilier
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
