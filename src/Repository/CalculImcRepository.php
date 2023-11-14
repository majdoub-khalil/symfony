<?php

namespace App\Repository;

use App\Entity\CalculImc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalculImc>
 *
 * @method CalculImc|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalculImc|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalculImc[]    findAll()
 * @method CalculImc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculImcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalculImc::class);
    }

//    /**
//     * @return CalculImc[] Returns an array of CalculImc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CalculImc
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
