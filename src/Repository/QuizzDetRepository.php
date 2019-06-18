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


    public function findAllUnanswered()
    {
        /* Unanswered == null */
        return $this->createQueryBuilder('q')
                    ->andWhere('q.result is null')
                    ->getQuery()
                    ->getResult()

            ;
    }

    public function findFirstUnanswered()
    {
        return $this->createQueryBuilder('q')
                    ->andWhere('q.result is null')
                    ->getQuery()->getResult();
    }

    public function findNextUnanswered($id)
    {
        return $this->createQueryBuilder('q')
                    ->andWhere('q.result is null')
                    ->andWhere('q.id > :id')
                    ->setParameter('id',$id)
                    ->orderBy('q.id', 'ASC')
                    ->getQuery()->getResult();
    }

    public function findPreviousUnanswered($id)
    {
        return $this->createQueryBuilder('q')
                    ->andWhere('q.result is null')
                    ->andWhere('q.id < :id')
                    ->setParameter('id',$id)
                    ->orderBy('q.id', 'DESC')
                    ->getQuery()->getResult();
    }


}
