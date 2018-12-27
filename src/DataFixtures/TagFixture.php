<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixture extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < BaseFixture::NUMBER_OF_TAGS; $i++) {
            $tag = new Tag();
            $tag->setName($this->faker->word);
            $this->addReference(TagFixture::class . $i, $tag);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}
