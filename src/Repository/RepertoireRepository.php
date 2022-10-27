<?php

namespace App\Repository;

use App\Entity\Repertoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repertoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repertoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repertoire[]    findAll()
 * @method Repertoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepertoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repertoire::class);
    }

    // /**
    //  * @return Repertoire[] Returns an array of Repertoire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function getPaginationRepertoire($page,$limit)
    {
        return $this->createQueryBuilder('r')
            
            ->orderBy('r.updatedAt', 'DESC')
            ->setFirstResult(($page*$limit)-$limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }


    public function filtreRepertoire( $ninea,$cuci,$denomination,$rccm)
    {
        $query= $this->createQueryBuilder('r')
              
               ;
           
        if($ninea){
            $query= $query
                    ->andWhere('r.ninea  like :ninea')
                    ->setParameter('ninea', "%".$ninea."%");
        }
        if($cuci){
            $query= $query
                    ->andWhere('r.codeCuci  like :cuci')
                    ->setParameter('cuci', "%".$cuci."%");
        }
        if($denomination){
            $query= $query
                    ->andWhere('r.denominationSocial  like :denomination')
                    ->setParameter('denomination', "%".$denomination."%");
        }
        if($rccm){
            $query= $query
                    ->andWhere('r.numeroRegistreCommerce  like :rccm')
                    ->setParameter('rccm', "%".$rccm."%");
        }
        return  $query= $query
                ->getQuery()
                ->getResult()
            ;
    }

    public function totalPage()
    {
        return $this->createQueryBuilder('r')
            ->select("count(r.id)")
            ->getQuery()->getSingleScalarResult()
        ;
    }


    public function exportationRepertoire($dateDebut,$dateFin,$dateDebutMaj,$dateFinMaj)
    {
        $query= $this->createQueryBuilder('r')
            ;
            
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.finExerciceComptable  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.finExerciceComptable  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }

        if($dateDebutMaj){
            $dateDebutMaj=new \DateTime( $dateDebutMaj);
            $query= $query
                    ->andWhere('r.updatedAt  >= :dateDebutMaj')
                    ->setParameter('dateDebutMaj', $dateDebutMaj);
        }
        if($dateFinMaj){
            $dateFinMaj=new \DateTime( $dateFinMaj." 23:00");
            $query= $query
                    ->andWhere('r.updatedAt  <= :dateFinMaj')
                    ->setParameter('dateFinMaj', $dateFinMaj);
        }
        return  $query= $query->getQuery()->getResult();
    }



    public function findNombreRepertoireNonLocaliser($dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->andWhere('r.qvh is null')
            ->select("count(r.id)");
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }


    public function findNombreRepertoireParRegion($code , $dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->innerJoin('r.qvh','qvh')
            ->addSelect('qvh')
            ->innerJoin('qvh.qvhCACRID','qvhCACRID')
            ->addSelect('qvhCACRID')
            ->innerJoin('qvhCACRID.cacrCAVID','cacrCAVID')
            ->addSelect('cacrCAVID')
            ->innerJoin('cacrCAVID.cavDEPID','cavDEPID')
            ->addSelect('cavDEPID')
            ->innerJoin('cavDEPID.depRegCD','depRegCD')
            ->addSelect('depRegCD')
            ->andWhere('depRegCD.id = :code')
            ->setParameter('code', $code);
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->getQuery()
                ->getResult()
            ;
    }


    public function findInterTableau($annee)
    {
        $query= $this->createQueryBuilder('r')
            ->leftJoin('r.bilans','bilans')
            ->addSelect('bilans')
        
            ;
        
        if($annee){
          
            $query= $query
                    ->andWhere('bilans.anneeFinanciere  = :annee')
                    ->setParameter('annee', $annee);
        }
       
        return  $query= $query
                ->groupBy('r.id')
                ->getQuery()
                ->getResult()
            ;
    }


    public function findNombreRepertoireDepartement( $dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->leftJoin('r.qvh','qvh')
            ->addSelect('qvh')
            ->leftJoin('qvh.qvhCACRID','qvhCACRID')
            ->addSelect('qvhCACRID')
            ->leftJoin('qvhCACRID.cacrCAVID','cacrCAVID')
            ->addSelect('cacrCAVID')
            ->leftJoin('cacrCAVID.cavDEPID','cavDEPID')
            ->addSelect('cavDEPID')
            ->select("count(r.id) as nombre, cavDEPID.description");
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->groupBy('cavDEPID.description')
                ->getQuery()
                ->getResult()
            ;
    }

    public function findNombreRepertoireControle( $dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->leftJoin('r.controle','c')
            ->addSelect('c')
           
            ->select("count(r.id) as nombre, c.libelle");
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->groupBy('c.libelle')
                ->getQuery()
                ->getResult()
            ;
    }

    public function findNombreRepertoireFormJuriduque( $dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->leftJoin('r.formeJuridique','f')
            ->addSelect('f')
           
            ->select("count(f.id) as nombre, f.libelle");
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->groupBy('f.libelle')
                ->getQuery()
                ->getResult()
            ;
    }

    public function findNombreRepertoireVille( $dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->leftJoin('r.qvh','qvh')
            ->addSelect('qvh')
            ->innerJoin('qvh.qvhCACRID','qvhCACRID')
            ->addSelect('qvhCACRID')
            ->innerJoin('qvhCACRID.cacrCAVID','cacrCAVID')
            ->addSelect('cacrCAVID')
           
            ->select("count(r.id) as nombre, cacrCAVID.libelle");
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->groupBy('cacrCAVID.libelle')
                ->getQuery()
                ->getResult()
            ;
    }


    public function findNombreRepertoireActiviter( $dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
            ->leftJoin('r.syscoa','s')
            ->addSelect('s')

            
           
            ->select("count(r.id) as nombre, s.libelle");
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->groupBy('s.libelle')
                ->getQuery()
                ->getResult()
            ;
    }
  
    public function findNombreRepertoire($dateDebut,$dateFin)
    {
        $query= $this->createQueryBuilder('r')
           ;
        
        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('r.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('r.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }
        return  $query= $query
                ->getQuery()
                ->getResult()
            ;
    }


                
    public function findNombreDeRepertoireCurrentYearMiseAjour($annee)
    {
        $date=new \DateTime( $annee."-07-01");
       
        $query= $this->createQueryBuilder('r')
            ->select("count(distinct r.codeCuci)")
            ->andWhere('r.updatedAt  >= :annee')
            ->setParameter('annee', $date);

        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }

    public function findNombreDeRepertoireCurrentYear($annee)
    {
        $query= $this->createQueryBuilder('r')
            ->select("count(r.id)");
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }



    
    public function findRCCM($rccm,$cuci)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.numeroRegistreCommerce = :rccm')
            ->setParameter('rccm', $rccm)
            ->andWhere('r.codeCuci <> :cuci')
            ->setParameter('cuci', $cuci)

            ->getQuery()
            ->getResult()
        ;
    }

    public function findninecuci($ninea,$cuci): ?Repertoire
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.ninea = :ninea')
            ->setParameter('ninea', $ninea)
            ->andWhere('r.codeCuci <> :cuci')
            ->setParameter('cuci', $cuci)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
