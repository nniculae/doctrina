<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function list(Request $request, ArticleRepository $articleRepository, PaginatorInterface $paginator): Response
    {
        $pageNumber = $request->query->getInt('page', 1);/*page number*/
        $pagination = $articleRepository->findAllPaginated($pageNumber, 10);
        return $this->render('article/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{tagName}", name="article_by_tag_name")
     * @param string $tagName
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function ListArticlesByTagName(string $tagName, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->listArticlesByTagNameExpr($tagName);
        return $this->render('tag/listByTagName.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{articleId}/tag/{tagId}", name="remove_tag_from_article")
     * @param int $articleId
     * @param int $tagId
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function removeTag(int $articleId, int $tagId, EntityManagerInterface $em): Response
    {
        $article = $em->find(Article::class, $articleId);
        if (!$article) {
            throw $this->createNotFoundException("Article not found");
        }
        $tag = $em->find(Tag::class, $tagId);
        if (!$tag) {
            throw $this->createNotFoundException("Tag Not found");
        }
        $article->removeTag($tag);
        $em->persist($article);
        $em->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
