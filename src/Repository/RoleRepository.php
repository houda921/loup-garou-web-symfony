<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }


    /**
    * @return Role[] Returns an array of Role objects
    */
    public function findByField($filter, $category) : array
    {
        return $this->findBy(["$filter" => "$category"]);
    }

    /**
    * @return Role[] Returns an array of Role objects, ordered by Faction
    */
    public function orderByFactions() : array
    {
        return array_merge(
            $this->findByField("id_faction", 1),
            $this->findByField("id_faction", 2),
            $this->findByField("id_faction", 3)
        );
    }

    /**
    * @return Object[][] Returns an array of array, ordered by Faction, each in a different arrays (+ additional data)
    */
    public function orderByFactionsArrays() : array
    {
        // Adding faction : Villageois
        $data[] = [
            "title" => "Villageois",
            "titleColor" => "#1e88e5",
            "roles" => $this->findByField("id_faction", 1)
        ];

        // Adding faction : Loups-Garou
        $data[] = [
            "title" => "Loups-Garou",
            "titleColor" => "#7b1b24",
            "roles" => $this->findByField("id_faction", 2)
        ];

        // Adding faction : Indépendants
        $data[] = [
            "title" => "Indépendants",
            "titleColor" => "#1de9b6",
            "roles" => $this->findByField("id_faction", 3)
        ];

        return $data;
    }



    // /**
    //  * @return Role[] Returns an array of Role objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Role
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}