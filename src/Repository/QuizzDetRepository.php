<?php

namespace App\Repository;

use App\Entity\QuizzDet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuizzDet|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizzDet|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizzDet[]    findAll()
 * @method QuizzDet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzDetRepository extends ServiceEntityRepository {

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
                    ->getResult();
    }

    public function findFirst($result)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q');
        if ($result === null)
        {
            $qb->andWhere('q.result is null');
        } else
        {
            $qb->andWhere('q.result=:result')->setParameter('result', 0);
        }

        return $qb->getQuery()->getResult();
    }

    public function findNext($id, $result)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q')
                   ->andWhere('q.id > :id')->setParameter('id', $id)
                   ->orderBy('q.id', 'ASC');


        if ($result === false)
        {
            $qb->andWhere('q.result is null');
        } else
        {
            $qb->andWhere('q.result=:result')->setParameter('result', 0);
        }

        return $qb->getQuery()->getResult();
    }


    public function findPrevious($id, $result)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q')
                   ->andWhere('q.id < :id')->setParameter('id', $id)
                   ->orderBy('q.id', 'DESC');

        if ($result === false)
        {
            $qb->andWhere('q.result is null');
        } else
        {
            $qb->andWhere('q.result=:result')->setParameter('result', $result);
        }

        return $qb->getQuery()->getResult();
    }

    public function getAllQuizCount()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q')
                   ->select('count(q.id) as zenbat')
                   ;

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCorrectAnswersCount()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q')
                    ->select('count(q.id) as zenbat')
                   ->andWhere('q.result = 1');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getIncorrectAnswersCount()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q')
                    ->select('count(q.id) as zenbat')
                   ->andWhere('q.result = 0');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getUnansweredCount()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('q')
                    ->select('count(q.id) as zenbat')
                   ->andWhere('q.result is null');

        return $qb->getQuery()->getSingleScalarResult();
    }


}
