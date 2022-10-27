<?php

namespace App\Repository;

use App\Entity\NinTypedocuments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NinTypedocuments>
 *
 * @method NinTypedocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method NinTypedocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method NinTypedocuments[]    findAll()
 * @method NinTypedocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NinTypedocumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NinTypedocuments::class);
    }

    public function add(NinTypedocuments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NinTypedocuments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NinTypedocuments[] Returns an array of NinTypedocuments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NinTypedocuments
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
