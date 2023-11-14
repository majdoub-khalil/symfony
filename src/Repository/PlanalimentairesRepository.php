<?php

namespace App\Repository;

use App\Entity\Planalimentaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Planalimentaires>
 *
 * @method Planalimentaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planalimentaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planalimentaires[]    findAll()
 * @method Planalimentaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanalimentairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planalimentaires::class);
    }

//    /**
//     * @return Planalimentaires[] Returns an array of Planalimentaires objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Planalimentaires
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
