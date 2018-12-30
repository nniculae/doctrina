<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testListArticles()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/articles');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            10,
            $crawler->filter('h3')->count()
        );
    }

    public function testListArticlesByTagName()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/ratione');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertGreaterThan(
            0,
            $crawler->filter('h3')->count(),
            'No articles found'
        );
    }
}