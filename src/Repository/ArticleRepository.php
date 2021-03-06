<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface as PagerPaginationInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    /** @var PaginatorInterface */
    private $paginator;

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);
        $this->paginator = $paginator;
    }

    public function findAllPaginated(int $pageNumber, int $limitPerPage = 10): PagerPaginationInterface
    {
        $criteria = Criteria::create()->orderBy(['a.pulishedAt' => Criteria::DESC]);
        $qb = $this->createQueryBuilder('a')
            ->addSelect(['c', 't'])
            ->leftJoin('a.category', 'c')
            ->leftJoin('a.tags', 't')
            ->addCriteria($criteria);
        return $this->paginator->paginate(
            $qb,
            $pageNumber,
            $limitPerPage
        );
    }

    public function ListArticlesByTagName(string $tagName)
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.tags', 't')
            ->andWhere('t.name = :tagName')
            ->setParameter('tagName', $tagName)
            ->getQuery()
            ->getResult();
    }

    public function listArticlesByTagNameExpr(string $tagName)
    {
        $qb = $this->createQueryBuilder('a');
        return $qb
            ->innerJoin('a.tags', 't')
            ->andWhere($qb->expr()->eq('t.name', ':tagName'))
//            ->andWhere(new Expr\Comparison('t.name', Expr\Comparison::EQ, ':tagName'))
            ->setParameters(['tagName' => $tagName])
            ->orderBy($qb->expr()->desc('a.title'))
//            ->orderBy(new Expr\OrderBy('a.title', Criteria::DESC))
            ->getQuery()
            ->getResult();
    }





    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
