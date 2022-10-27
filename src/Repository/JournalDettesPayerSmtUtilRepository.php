<?php

namespace App\Repository;

use App\Entity\JournalDettesPayerSmtUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JournalDettesPayerSmtUtil>
 *
 * @method JournalDettesPayerSmtUtil|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalDettesPayerSmtUtil|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalDettesPayerSmtUtil[]    findAll()
 * @method JournalDettesPayerSmtUtil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalDettesPayerSmtUtilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JournalDettesPayerSmtUtil::class);
    }

    public function add(JournalDettesPayerSmtUtil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JournalDettesPayerSmtUtil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JournalDettesPayerSmtUtil[] Returns an array of JournalDettesPayerSmtUtil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JournalDettesPayerSmtUtil
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
