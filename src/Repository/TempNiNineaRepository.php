<?php

namespace App\Repository;

use App\Entity\TempNINinea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempNiNinea>
 *
 * @method TempNiNinea|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempNiNinea|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempNiNinea[]    findAll()
 * @method TempNiNinea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempNiNineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempNINinea::class);
    }

    public function add(TempNINinea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TempNINinea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
            ->groupBy("tn.ninNinea")
            ->orderBy("tn.createdAt", "DESC")
            ->getQuery()
            ->getResult()
        ;
    }

    public function distinctGroupTempNINineaNoFilter(){
        
        $query = $this->createQueryBuilder('tn');

        return $query
            ->groupBy("tn.ninNinea")
            ->orderBy("tn.createdAt", "DESC")
            ->getQuery()
            ->getResult()
        ;
    }


    public function distinctTempNINinea(){
        
        $query = $this->createQueryBuilder('tn');
        return $query->select('tn.ninNinea')
            ->distinct(true)
            ->getQuery()
            ->getResult()
            ;
    }


//    /**
//     * @return TempNiNinea[] Returns an array of TempNiNinea objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TempNiNinea
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
