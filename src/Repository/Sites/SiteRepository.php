<?php

namespace App\Repository\Sites;

use App\Entity\Sites\Site;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site|null findOneBy(array $criteria, array $orderBy = null)
 * @method Site[]    findAll()
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function findAllLocalStorage()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder=$entityManager->createQueryBuilder();
        $queryBuilder
            ->select('SUM(s.localStorage)')
            ->from(Site::class, 's');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function findAllSessionStorage()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder=$entityManager->createQueryBuilder();
        $queryBuilder
            ->select('SUM(s.sessionStorage)')
            ->from(Site::class, 's');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function findAllCookie()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder=$entityManager->createQueryBuilder();
        $queryBuilder
            ->select('SUM(s.cookie)')
            ->from(Site::class, 's');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Site[] Returns an array of Site objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Site
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
