<?php

namespace App\Repository;

use App\Entity\TempNiCoordonnees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempNiCoordonnees>
 *
 * @method TempNiCoordonnees|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempNiCoordonnees|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempNiCoordonnees[]    findAll()
 * @method TempNiCoordonnees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempNiCoordonneesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempNiCoordonnees::class);
    }

    public function add(TempNiCoordonnees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TempNiCoordonnees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TempNiCoordonnees[] Returns an array of TempNiCoordonnees objects
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

//    public function findOneBySomeField($value): ?TempNiCoordonnees
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
