<?php

namespace App\DataFixtures;

use Faker\Generator;
use Faker\Factory;
use App\Entity\Ingredien;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct() {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++){
            $ingredient = new Ingredien();
            $ingredient -> setName($this->faker->word())
                ->setPrice(mt_rand(0, 100));

            $manager->persist($ingredient);
        }
                

        $manager->flush();
    }
}
