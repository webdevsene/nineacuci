<?php

namespace App\Repository;

use App\Entity\ProductionDeExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductionDeExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionDeExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionDeExercice[]    findAll()
 * @method ProductionDeExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionDeExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductionDeExercice::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ProductionDeExercice $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findNombreProduction($annee)
    {
        $query= $this->createQueryBuilder('p')
            ->innerJoin('p.repertoire','r')
            ->addSelect('r')
            ->select("count(distinct r.id)")
            ->andWhere('p.anneeFinanciere = :annee_financiere')
            ->setParameter('annee_financiere', $annee);
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }


    public function findInterTableau($annee)
    {
        $query= $this->createQueryBuilder('p')
            ->leftJoin('p.repertoire','r')
            ->addSelect('r')
            ->select(' distinct r.id , p.submit') 
            ;
        
        if($annee){
          
            $query= $query
                    ->andWhere('p.anneeFinanciere  = :annee')
                    ->setParameter('annee', $annee);
        }
       
        return  $query= $query
                
                ->getQuery()
                ->getResult()
            ;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ProductionDeExercice $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ProductionDeExercice[] Returns an array of ProductionDeExercice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductionDeExercice
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
