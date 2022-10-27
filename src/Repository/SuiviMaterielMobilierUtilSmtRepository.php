<?php

namespace App\Repository;

use App\Entity\SuiviMaterielMobilierUtilSmt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuiviMaterielMobilierUtilSmt>
 *
 * @method SuiviMaterielMobilierUtilSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviMaterielMobilierUtilSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviMaterielMobilierUtilSmt[]    findAll()
 * @method SuiviMaterielMobilierUtilSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviMaterielMobilierUtilSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviMaterielMobilierUtilSmt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SuiviMaterielMobilierUtilSmt $entity, bool $flush = true): void
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
    public function remove(SuiviMaterielMobilierUtilSmt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return SuiviMaterielMobilierUtilSmt[] Returns an array of SuiviMaterielMobilierUtilSmt objects
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
    public function findOneBySomeField($value): ?SuiviMaterielMobilierUtilSmt
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
