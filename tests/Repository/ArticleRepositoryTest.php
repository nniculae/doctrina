<?php

namespace App\Tests\Repository;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;



    public function testFindAllPaginated()
    {
        $articles = $this->entityManager
            ->getRepository(Article::class)
            ->findAllPaginated(1,10);
        $this->assertCount(10, $articles);
        $this->assertNotNull($articles[0]->getCategory());
        $this->assertNotNull($articles[0]->getTags());
    }

    public function testListArticlesByTagNameExpr()
    {

        $articles = $this->entityManager
            ->getRepository(Article::class)
            ->listArticlesByTagNameExpr('porro');
        $this->assertCount(8,$articles);

    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}