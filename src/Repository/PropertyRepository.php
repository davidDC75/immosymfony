<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Property;
use App\Entity\PropertySearch;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Retourne tous les biens qui n'ont pas été vendus
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query // On ne renvoie pas un résultat mais une query afin d'être utilisé avec le paginator
    {
        $query=$this->findVisibleQuery();

        if ($search->getMaxPrice())
        {
            $query=$query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice',$search->getMaxPrice());
        }

        if ($search->getMinSurface())
        {
            $query=$query
                ->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface',$search->getMinSurface());
        }

        return $query->getQuery();
    }

    /**
     * Retourne les 4 derniers biens ajoutés
     * @return \App\Entity\Property[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * Permet d'éviter de se répéter. Retourne un where pour les biens non vendus
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }
}
