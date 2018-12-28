<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_list")
     */
    public function list(ArticleRepository $articleRepository)
    {
        //dump($articleRepository->loadAll()); die;
        $articles = $articleRepository->findAllWithCategoriesAndTags();
        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }
}
