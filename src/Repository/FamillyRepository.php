<?php

namespace App\Repository;

use App\Entity\Familly;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Familly|null find($id, $lockMode = null, $lockVersion = null)
 * @method Familly|null findOneBy(array $criteria, array $orderBy = null)
 * @method Familly[]    findAll()
 * @method Familly[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamillyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Familly::class);
    }

    // /**
    //  * @return Familly[] Returns an array of Familly objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Familly
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
