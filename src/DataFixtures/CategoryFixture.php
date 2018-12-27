<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < BaseFixture::NUMBER_OF_CATEGORIES; $i++) {
            $category = new Category();
            $category->setName($this->faker->word);
            $this->addReference(CategoryFixture::class . $i, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
