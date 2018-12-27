<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixture extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < BaseFixture::NUMBER_OF_ARTICLES; $i++) {
            $article = new Article();
            $article->setTitle($this->faker->sentence);
            $article->setContent($this->faker->sentence(10));
            $article->setPulishedAt($this->faker->dateTimeBetween('-2 years', 'now'));
            $this->addCategory($article);
            $this->addTags($article);
            $manager->persist($article);
        }
        $manager->flush();
    }

    /**
     * @param $article
     */
    private function addCategory($article): void
    {
        /** @var Category $category */
        $category = $this->getReference(CategoryFixture::class . rand(0, BaseFixture::NUMBER_OF_CATEGORIES - 1));
        $article->setCategory($category);
    }

    /**
     * @param $article
     */
    private function addTags($article): void
    {
        $maxTags = rand(1, 5);
        for ($i = 0; $i < $maxTags; $i++) {
            /** @var Tag $tag */
            $tag = $this->getReference(TagFixture::class . rand(0, BaseFixture::NUMBER_OF_TAGS - 1));
            $article->addTag($tag);
        }
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CategoryFixture::class,
            TagFixture::class,
        ];
    }
}
