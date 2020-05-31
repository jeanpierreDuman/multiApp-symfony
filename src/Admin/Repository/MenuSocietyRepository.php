<?php

namespace App\Admin\Repository;

use App\Admin\Entity\MenuSociety;
use App\Admin\Entity\Society;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MenuSociety|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuSociety|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuSociety[]    findAll()
 * @method MenuSociety[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuSocietyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuSociety::class);
    }

    public function getMenuForSociety(Society $society, $route)
    {
        return $this->createQueryBuilder('ms')
            ->join('ms.society', 'ms_s')
            ->join('ms.menu', 'ms_m')
            ->where('ms_s.id = :societyId')
            ->andWhere('ms_m.route = :route')
            ->setParameter('societyId', $society->getId())
            ->setParameter('route', $route)
            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return MenuSociety[] Returns an array of MenuSociety objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MenuSociety
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
