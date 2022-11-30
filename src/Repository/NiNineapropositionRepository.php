<?php

namespace App\Repository;

use App\Entity\NiNineaproposition;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiNineaproposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiNineaproposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiNineaproposition[]    findAll()
 * @method NiNineaproposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiNineapropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiNineaproposition::class);
    }

    // /**
    //  * @return NiNineaproposition[] Returns an array of NiNineaproposition objects
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

    public function findByField($numero,$formejuridique, $statut,$nom, $prenom, $cni)
    {
        $query= $this->createQueryBuilder('n');

       if($numero){
        $query += $query
            ->andWhere('n.ninNumeroDemande = :numero')
            ->setParameter('numero', $numero);
       }

       if($formejuridique){
            $query += $query
            ->andWhere('n.ninFormejuridique = :forme')
            ->setParameter('forme', $formejuridique);
       }

       if($statut){
        $query += $query
        ->andWhere('n.ninStatut = :statut')
        ->setParameter('statut', $statut);
        }  

        if($prenom){
            $query += $query
            ->andWhere('n.ninFormejuridique = :forme')
            ->setParameter('forme', $formejuridique);
        }  
        
        if($prenom){
            $query += $query
            ->andWhere('n.ninFormejuridique = :forme')
            ->setParameter('forme', $formejuridique);
        }  if($formejuridique){
            $query += $query
            ->andWhere('n.ninFormejuridique = :forme')
            ->setParameter('forme', $formejuridique);
        }
       $query += $query  
       ->orderBy('n.id', 'ASC')
       ->getQuery()
       ->getResult();

       return $query;
          
    }

    
   
    public function findByCentre($user)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy','u')
            ->addSelect('u')
            ->andWhere('u.niAdministration = :administration')
            ->setParameter('administration', $user->getNiAdministration())
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;          
    }

    
    public function findByCentre2($user, $notStatut)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy','u')
            ->addSelect('u')
            ->andWhere('u.niAdministration = :administration and n.statut != :statut')
            ->setParameter('administration', $user->getNiAdministration())
            ->setParameter('statut', $notStatut)
            ->orderBy('n.id', 'desc')
            ->getQuery()
            ->getResult()
        ;          
    }

    //liste des demandes de statut "b"
    public function findBrouillonsByCentre($user, $statut)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')
            ->andWhere('u.niAdministration = :administration and n.statut = :statut')
            ->setParameter('administration', $user->getNiAdministration())
            ->setParameter('statut', $statut)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    
    public function findDemandeValideeByCentre($dateDebut, $dateFin)
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.createdBy','u')
        ->addSelect('u')
        ->innerJoin('u.niAdministration','a')
        ->addSelect('a')
        ->andWhere('n.statut = :statut')
        ->setParameter('statut', "v")
        ->select("count(n.id) as nombre, a.admlibelle")
        ;

        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('n.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('n.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }

        return $query= $query
                ->groupBy('a.admlibelle')       
                ->getQuery()
                ->getResult()
    ;          
    }

    
    public function findDirigeantEtrangerByNinea($cni,$ind, $idDemande,$iddirig)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.ninDirigeants', 'p')
        ->addSelect('p')
        ->innerJoin('p.ninNationalite', 'na')
        ->addSelect('na')
        ->andWhere('p.ninCni LIKE :cni')
        ->setParameter('cni', $cni)
        ->andWhere('na.id = :ind')
        ->andWhere('n.ninNinea is null')
        ->setParameter('ind', $ind)
        ->andWhere('n.id = :idDemande')
        ->setParameter('idDemande', $idDemande);
        
       
        if($iddirig){
            $query=$query ->andWhere('p.id != :iddirig')
              ->setParameter('iddirig', $iddirig);
        }
       

        return $query=$query
        ->getQuery()
        ->getResult();
    }

    public function findDirigeantCNIByNinea($cni,$ind)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.ninDirigeants', 'p')
        ->addSelect('p')
        ->innerJoin('p.ninNationalite', 'na')
        ->addSelect('na')
        ->andWhere('p.ninCni LIKE :cni')
        ->setParameter('cni', $cni)
        ->andWhere('na.id = :ind')
        ->setParameter('ind', $ind)
        ->getQuery()
        ->getResult();

        return $query;
    }


    public function findDemandeEnAttenteByCentre()
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.createdBy','u')
        ->addSelect('u')
        ->innerJoin('u.niAdministration','a')
        ->addSelect('a')
        ->andWhere('n.statut = :statut')
        ->setParameter('statut', "v")
        ->select("count(n.id) as nombre, a.admlibelle")
        ;

        return $query= $query
                ->groupBy('a.admlibelle')       
                ->getQuery()
                ->getResult() ;          
    }


    //pour l'agent de saisie toutes les demandes validées
    public function findDemandeValideeByUser($user,$dateDebut, $dateFin)
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.createdBy','u')
        ->addSelect('u')
        ->innerJoin('u.niAdministration','a')
        ->addSelect('a')
        ->andWhere('n.statut = :statut')
        ->setParameter('statut', "v")
        ->select("count(n.id) as nombre, u.prenom as prenom, u.nom as nom")
        ;
        if($user){
            $query= $query
            ->andWhere('u.niAdministration = :administration')
            ->setParameter('administration', $user->getNiAdministration());
        }

        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('n.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('n.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }

        return $query= $query
                ->groupBy('u.id')
                ->groupBy('u.prenom', 'u.nom')
                ->getQuery()
                ->getResult()
    ;          
    }

    //liste des demandes créées 
    public function findDemandesByUser($user, $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')
            ->innerJoin('u.niAdministration', 'a')
            ->addSelect('a')          
            ->select("count(n.id) as nombre, u.prenom as prenom, u.nom as nom");
        if ($user) {
            $query = $query
                ->andWhere('u.niAdministration = :administration')
                ->setParameter('administration', $user->getNiAdministration());
        }

        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('u.id')
            ->groupBy('u.prenom', 'u.nom')
            ->getQuery()
            ->getResult();
    }

    
    
    public function findValidationByUser( $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.updatedBy', 'u')
            ->addSelect('u')           
            ->andWhere('n.statut = :statut')
            ->setParameter('statut', "v")
            ->select("count(n.id) as nombre, u.prenom as prenom, u.nom as nom");
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('u.id')
            ->groupBy('u.prenom', 'u.nom')
            ->getQuery()
            ->getResult();
    }


   /*  public function findByValidation($statut)
    {

        return $this->createQueryBuilder('n')
            ->andWhere('n.statut != :statut')
            ->setParameter('statut', $statut)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;          
    }
 */


    public function findByValidation($user, $statut)
    {
        return $this->createQueryBuilder('n')
            ->andWhere(' n.statut != :statut')
            ->orWhere('n.createdBy = :user ')
            ->setParameter('statut', $statut)
            ->setParameter('user', $user)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult() ;          
    }


public function getCNIControle($cni)
{

    return $this->createQueryBuilder('n')
        ->innerJoin('n.niPersonnes','p')
        ->addSelect('p')
        ->andWhere('p.ninCNI = :cni')
        ->setParameter('cni',$cni)
        ->getQuery()
        ->getResult()
    ;          
}
 
public function findByDemandeEnValidation( $statut)
{
    return $this->createQueryBuilder('n')
        ->andWhere('n.statut = :statut')
        ->setParameter('statut', $statut)       
        ->orderBy('n.id', 'ASC')
        ->getQuery()
        ->getResult()
    ;          
}


    public function findByDemande( $user,$statut)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.statut = :statut')
            ->andWhere('n.createdBy = :user')
            ->setParameter('statut', $statut)
            ->setParameter('user', $user)        
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;          
    }

    public function findAValider()
    {
        return $this->createQueryBuilder('n')
            //->andWhere('n.statut = :statut /*or n.statut = :valider or n.statut = :rejeter*/')
            ->andWhere('n.statut = :statut ')
            ->setParameter('statut', "c")
            //->setParameter('valider', "t")
            //->setParameter('rejeter', "r")
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    
    public function findDemande()
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.statut != :statut ')
            ->setParameter('statut', "b")
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    

    public function findByCreatedAtAndNiAdmin($var , $var2 , $varCsi)
    {
        $query = $this->createQueryBuilder('ni');

        if ($varCsi) {
            $query = $query->innerJoin('ni.createdBy', 'demandeur')
                        ->addSelect('demandeur')
                        ->innerJoin('demandeur.niAdministration', 'csi')
                        ->andWhere('ni.statut = :v')
                        ->setParameter('v', 'v')
                        ->addSelect('csi')
                        ->andWhere('csi.id = :varCsi')
                        ->setParameter('varCsi', $varCsi)
            ;
        }
        if ($var) {
            $var = new \DateTime($var);
            // $var = $var->format('Y-m-d');
            $query = $query->andWhere('ni.createdAt >= :var')
                        ->setParameter('var',$var);
        }
        if ($var2) {
            $var2 = new \DateTime($var2);
           //  $var2 = $var2->format('Y-m-d');

            $query = $query->andWhere('ni.createdAt <= :var2')
                        ->setParameter('var2',$var2);
        }

        return $query = $query->getQuery()
                              ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?NiNineaproposition
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