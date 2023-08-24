<?php

namespace App\Repository;

use App\Entity\AboutWebSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AboutWebSite>
 *
 * @method AboutWebSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutWebSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutWebSite[]    findAll()
 * @method AboutWebSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutWebSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutWebSite::class);
    }

//    /**
//     * @return AboutWebSite[] Returns an array of AboutWebSite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AboutWebSite
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
