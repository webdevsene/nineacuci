<?php

namespace App\Repository;

use App\Entity\AchatProduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AchatProduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AchatProduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AchatProduction[]    findAll()
 * @method AchatProduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AchatProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AchatProduction::class);
    }

    // /**
    //  * @return AchatProduction[] Returns an array of AchatProduction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findNombreAchat($annee)
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
        $query= $this->createQueryBuilder('c')
            ->leftJoin('c.repertoire','r')
            ->addSelect('r')
            ->select(' distinct r.id , c.submit') 
            ;
        
        if($annee){
          
            $query= $query
                    ->andWhere('c.anneeFinanciere  = :annee')
                    ->setParameter('annee', $annee);
        }
       
        return  $query= $query
               
                ->getQuery()
                ->getResult()
            ;
    }
    
    /**
     * @return AchatProduction[] Returns an array of AchatProduction objects
     */    
    public function findByCodeCuci($codeCuci, $annee)
    {
        return $this->createQueryBuilder('e')

            ->innerJoin('e.repertoire','r')
            ->addSelect('r')
            ->andWhere('e.anneeFinanciere = :annee')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?AchatProduction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
