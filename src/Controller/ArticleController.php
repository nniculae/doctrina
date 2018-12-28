<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
//use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article_list")
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request, ArticleRepository $articleRepository, PaginatorInterface $paginator):Response
    {
        $qb = $articleRepository->findAllWithCategoriesAndTags();
        $pagination = $paginator->paginate(
            $qb, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('article/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
