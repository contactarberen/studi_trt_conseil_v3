<?php

namespace App\Repository;

use App\Entity\AttributsRecruteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AttributsRecruteur>
 *
 * @method AttributsRecruteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributsRecruteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributsRecruteur[]    findAll()
 * @method AttributsRecruteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributsRecruteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributsRecruteur::class);
    }

    public function save(AttributsRecruteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AttributsRecruteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AttributsRecruteur[] Returns an array of AttributsRecruteur objects
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

//    public function findOneBySomeField($value): ?AttributsRecruteur
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
