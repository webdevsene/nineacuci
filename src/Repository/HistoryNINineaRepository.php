<?php

namespace App\Repository;

use App\Entity\HistoryNINinea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNINinea>
 *
 * @method HistoryNINinea|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNINinea|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNINinea[]    findAll()
 * @method HistoryNINinea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNINineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNINinea::class);
    }

    public function add(HistoryNINinea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNINinea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function distinctHistoryNINinea(){
        return $this->createQueryBuilder('cc')
        ->select('cc.ninNinea')
        ->distinct('cc.ninNinea')
        ->getQuery()
        ->getResult()
        ;
    }

    
    public function distinctGroupTempNINinea($id, $dateDebut, $dateFin){
        
        $query = $this->createQueryBuilder('tn');

        if($id){
            $query = $query
                ->andWhere('tn.ninNinea  LIKE :numero')
                ->setParameter('numero', $id.'%');
        }

        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            // $var = $var->format('Y-m-d');
            $query = $query->andWhere('tn.createdAt >= :var')
                        ->setParameter('var',$dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
           //  $var2 = $var2->format('Y-m-d');

            $query = $query->andWhere('tn.createdAt <= :var2')
                        ->setParameter('var2',$dateFin);
        }

        return $query
            ->orderBy("tn.createdAt", "DESC")
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function distinctGroupTempNINineaNoFilter(){
        
        $query = $this->createQueryBuilder('hn');

        return $query
            ->groupBy("hn.ninNinea")
            ->orderBy("hn.createdAt", "DESC")
            ->getQuery()
            ->getResult()
        ;
    }

    
//    /**
//     * @return HistoryNINinea[] Returns an array of HistoryNINinea objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoryNINinea
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
