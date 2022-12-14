<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Movie $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Movie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Find all oredered by title ASC by DQL
     */
    public function findAllOrderedByTitleASC()
    {
        //L'EM est nécessaire pour créer une requete
        $entityManager = $this->getEntityManager();

        //on créer une requete depuis l'EM
        //En Doctrine Query Language (DQL)
        $query = $entityManager->createQuery(
            'SELECT m
            FROM App\Entity\Movie m
            ORDER BY m.title ASC'
        );

        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     * Find all oredered by title ASC by Query Builder
     */
    public function findAllOrderedByTitleAscQB()
    {
        return $this->createQueryBuilder('m')
                    ->orderBy('m.title', 'DESC')
                    ->getQuery()
                    ->getResult();
    
    }

    /**
     * Find 10 last films order by release date (QB)
     */
    public function findAllOrderedByRealaseDateDscQB()
    {
        return $this->createQueryBuilder('m')
                    ->orderBy('m.releaseDate', 'DESC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Find all oredered by release date ASC by DQL
     */
    public function findAllOrderedByRealaseDateDscDBL()
    {
        //L'EM est nécessaire pour créer une requete
        $entityManager = $this->getEntityManager();

        //on créer une requete depuis l'EM
        //En Doctrine Query Language (DQL)
        $query = $entityManager->createQuery(
            'SELECT m
            FROM App\Entity\Movie m
            ORDER BY m.releaseDate DESC'
        )->setMaxResults(10);

        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     * Find Movies By Name Genre
     */
    public function findAllMovieByNameGenre($name)
    {
        $sql="  SELECT * FROM `movie`
                INNER JOIN `movie_genre`
                ON `movie_genre`.`movie_id`=`movie`.`id`
                INNER JOIN `genre`
                ON `genre`.`id`=`movie_genre`.`genre_id`
                WHERE `genre`.`name`=:name
            ";
            
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $results = $stmt->executeQuery(['name' => $name]);

        return $results->fetchAllAssociative();
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
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
    public function findOneBySomeField($value): ?Movie
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
