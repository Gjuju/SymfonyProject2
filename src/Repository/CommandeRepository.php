<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }




    public const PAGINATOR_PER_PAGE = 10;

    public function getAdminCommandePaginator(int $offset): Paginator
    {

        // SELECT *, SUM(produit_prix * produit_quantite) as total FROM commande GROUP BY created_at
        // SELECT *, SUM(produit_prix * produit_quantite) as total FROM commande GROUP BY created_at DESC
        $query = $this->createQueryBuilder('c');

        
        $query->select('c')
            //->addSelect('SUM(c.produit_prix * c.produit_quantite) as total')
            ->groupBy('c.createdAt')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
            //->getArrayResult();

        return new Paginator($query);
    }

    public function getUserCommandePaginator(int $offset, int $id): Paginator
    {

        // SELECT *, SUM(produit_prix * produit_quantite) as total FROM commande GROUP BY created_at
        // SELECT *, SUM(produit_prix * produit_quantite) as total FROM commande GROUP BY created_at DESC
        $query = $this->createQueryBuilder('c');

        $query->select('c')
            //->addSelect('SUM(c.produit_prix * c.produit_quantite) as total')
            ->andWhere('c.utilisateur = :id')
            ->setParameter('id', $id)
            ->groupBy('c.createdAt')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
            //->getArrayResult();

        return new Paginator($query);
    }

    public function getDetailCommandePaginator(int $user, string $createdAt): Paginator
    {

        // SELECT *, SUM(produit_prix * produit_quantite) as total FROM `commande` WHERE utilisateur_id = ? GROUP BY created_at
        $query = $this->createQueryBuilder('c');

        $query->select('c')
            /* ->addSelect('(c.produit_prix * c.produit_quantite) as total') */
            ->andWhere('c.utilisateur = :id')
            ->setParameter('id', $user)
            ->andWhere('c.createdAt = :createdAt')
            ->setParameter('createdAt', $createdAt)
            //->groupBy('c.createdAt')
            ->getQuery()
            ->getArrayResult();

        return new Paginator($query);
    }
// récupérer toutes les lignes d'une commande spécifique :
// SELECT * (produit_prix * produit_quantite) as total FROM `commande` WHERE utilisateur_id = ? AND created_at = ?

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commande
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
