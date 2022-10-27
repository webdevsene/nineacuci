<?php

namespace App\Repository;

use App\Entity\Effectifs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Effectifs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Effectifs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Effectifs[]    findAll()
 * @method Effectifs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EffectifsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Effectifs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Effectifs $entity, bool $flush = true): void
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
    public function remove(Effectifs $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findNombreEffectif($annee)
    {
        $query= $this->createQueryBuilder('e')
            ->innerJoin('e.repertoire','r')
            ->addSelect('r')
            ->select("count(distinct r.id)")
            ->andWhere('e.anneeFinanciere = :annee_financiere')
            ->setParameter('annee_financiere', $annee);
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }


    public function findInterTableau($annee)
    {
        $query= $this->createQueryBuilder('e')
            ->leftJoin('e.repertoire','r')
            ->addSelect('r')
            ->select(' distinct r.id , e.submit') 
            ;
        
        if($annee){
          
            $query= $query
                    ->andWhere('e.anneeFinanciere  = :annee')
                    ->setParameter('annee', $annee);
        }
       
        return  $query= $query
               
                ->getQuery()
                ->getResult()
            ;
    }

    // /**
    //  * @return Effectifs[] Returns an array of Effectifs objects
    //  */    
    public function findByCodeCuci($codeCuci, $annee, $type)
    {
        return $this->createQueryBuilder('e')

            ->innerJoin('e.repertoire','r')
            ->addSelect('r')
            ->andWhere('e.anneeFinanciere = :annee')
            ->andWhere('e.type = :type')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('type', $type)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }
   

    /*
    public function findOneBySomeField($value): ?Effectifs
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
