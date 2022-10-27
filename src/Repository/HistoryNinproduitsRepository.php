<?php

namespace App\Repository;

use App\Entity\HistoryNinproduits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNinproduits>
 *
 * @method HistoryNinproduits|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNinproduits|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNinproduits[]    findAll()
 * @method HistoryNinproduits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNinproduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNinproduits::class);
    }

    public function add(HistoryNinproduits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNinproduits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryNinproduits[] Returns an array of HistoryNinproduits objects
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

//    public function findOneBySomeField($value): ?HistoryNinproduits
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
