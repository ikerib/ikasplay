<?php

namespace App\Repository;

use App\Entity\QuizzDet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuizzDet|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizzDet|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizzDet[]    findAll()
 * @method QuizzDet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzDetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuizzDet::class);
    }

    // /**
    //  * @return QuizzDet[] Returns an array of QuizzDet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuizzDet
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
