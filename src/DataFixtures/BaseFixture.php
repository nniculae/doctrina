<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

abstract class BaseFixture extends Fixture
{
    protected $faker;
    const NUMBER_OF_ARTICLES = 50;
    const NUMBER_OF_CATEGORIES = 10;
    const NUMBER_OF_TAGS = 25;
    /**
     * BaseFixture constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }
}