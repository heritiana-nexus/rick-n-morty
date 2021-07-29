<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @return Character[] Returns an array of Character objects
     */
    public function findByParams($params)
    {

        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.location', 'location');
        if(isset($params['name'])) {
            $qb->andWhere('c.name = :name')->setParameter(':name', $params['name']);
        }
        if(isset($params['type'])) {
            $qb->andWhere('c.type = :type')->setParameter(':type', $params['type']);
        }
        if(isset($params['gender'])) {
            $qb->andWhere('c.gender = :gender')->setParameter(':gender', $params['gender']);
        }
        if(isset($params['species'])) {
            $qb->andWhere('c.species = :species')->setParameter(':species', $params['species']);
        }
        if(isset($params['status'])) {
            $qb->andWhere('c.status = :status')->setParameter(':status', $params['status']);
        }

        return $qb;
    }

    /*
    public function findOneBySomeField($value): ?Character
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
