<?php

namespace App\Repository;

use App\Entity\ComptederesultatSmt; 
use App\Entity\RefAggSmt;  
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComptederesultatSmt>
 *
 * @method ComptederesultatSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComptederesultatSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComptederesultatSmt[]    findAll()
 * @method ComptederesultatSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComptederesultatSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComptederesultatSmt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ComptederesultatSmt $entity, bool $flush = true): void
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
    public function remove(ComptederesultatSmt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }



    public function findByCodeCuci($codeCuci,$annee)
    {
        return $this->createQueryBuilder('b')

            // ->innerJoin('b.repertoire','r')
            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            // ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return ComptederesultatSmt[] Returns an array of ComptederesultatSmt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComptederesultatSmt
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
