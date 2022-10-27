<?php

namespace App\Repository;

use App\Entity\HistoryNiCoordonnees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNiCoordonnees>
 *
 * @method HistoryNiCoordonnees|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNiCoordonnees|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNiCoordonnees[]    findAll()
 * @method HistoryNiCoordonnees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNiCoordonneesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNiCoordonnees::class);
    }

    public function add(HistoryNiCoordonnees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNiCoordonnees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryNiCoordonnees[] Returns an array of HistoryNiCoordonnees objects
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

//    public function findOneBySomeField($value): ?HistoryNiCoordonnees
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
