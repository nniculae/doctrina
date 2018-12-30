<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
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
        $pageNumber = $request->query->getInt('page', 1);/*page number*/
        $pagination = $articleRepository->findAllPaginated($pageNumber,10);

        return $this->render('article/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{tagName}", name="article_by_tag_name")
     */
    public function ListArticlesByTagName(string $tagName, ArticleRepository $articleRepository ):Response
    {

        $articles = $articleRepository->ListArticlesByTagName($tagName);

        return $this->render('tag/listByTagName.html.twig',[
            'articles' => $articles
        ]);

    }
}
