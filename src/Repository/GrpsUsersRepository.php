<?php

namespace App\Repository;

use App\Entity\GrpsUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GrpsUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrpsUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrpsUsers[]    findAll()
 * @method GrpsUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrpsUsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GrpsUsers::class);
    }

    // /**
    //  * @return GrpsUsers[] Returns an array of GrpsUsers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GrpsUsers
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
