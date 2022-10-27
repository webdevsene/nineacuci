<?php

namespace App\Repository;

use App\Entity\TempNiDirigeant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempNiDirigeant>
 *
 * @method TempNiDirigeant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempNiDirigeant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempNiDirigeant[]    findAll()
 * @method TempNiDirigeant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempNiDirigeantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempNiDirigeant::class);
    }

    public function add(TempNiDirigeant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TempNiDirigeant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TempNiDirigeant[] Returns an array of TempNiDirigeant objects
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

//    public function findOneBySomeField($value): ?TempNiDirigeant
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
