<?php

namespace App\Repository;

use App\Entity\Leader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Leader|null find($id, $lockMode = null, $lockVersion = null)
 * @method Leader|null findOneBy(array $criteria, array $orderBy = null)
 * @method Leader[]    findAll()
 * @method Leader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeaderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Leader::class);
    }

    /**
     * Get leader without games
     * @param int $limit
     * @return mixed
     */
    public function getFreeLeaders() {
        return $this->createQueryBuilder('l')
            ->where('SIZE(l.games) = 0')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Get leaders wit minimum games
     *
     * @param $gamesCount
     * @return mixed
     */
    public function getLeadersByGamesCount($gamesCount)
    {
        return $this->createQueryBuilder('l')
           ->where('l.gamesCount = :gamesCount')
            ->setParameter('gamesCount', $gamesCount)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Get min games count from leaders table
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMinGamesCount()
    {
        return $this->createQueryBuilder('l')
            ->select('MIN(l.gamesCount)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return Leader[] Returns an array of Leader objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Leader
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
