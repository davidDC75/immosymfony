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
 * @method Query         findAllVisibleQuery(PropertySearch $search)
 * @method Property[]    findLatest()
 * @method QueryBuilder  findVisibleQuery()
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
     * findAllAdmin
     *
     * @return \Doctrine\ORM\Query
     */
    public function findAllAdmin(): Query
    {
        return $this->createQueryBuilder('p')
            ->getQuery();
    }
    /**
     * Retourne tous les biens qui n'ont pas été vendus
     * @return \Doctrine\ORM\Query
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

        if ($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query = $query
                ->select ( 'p')
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  PI()/180 / 2), 2) +COS(p.lat * PI()/180) * COS(:lat * PI()/180) * POWER(SIN((p.lng - :lng) * PI()/180 / 2), 2) )) ) <= :distance')
                ->setParameter('lng',$search->getLng())
                ->setParameter('lat',$search->getLat())
                ->setParameter('distance',$search->getDistance());
        }

        if ($search->getOptions()->count() > 0)
        {
            $k=0;
            foreach($search->getOptions() as $option)
            {
                $query=$query
                    ->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter("option$k",$option);
                $k++;
            }
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
