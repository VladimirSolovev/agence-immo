<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i=0; $i < 100; $i++){
            $property = new Property();
            $property->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(20, 350))
                ->setRooms($faker->numberBetween(1, 6))
                ->setBedrooms($faker->numberBetween(1, 5))
                ->setFloor($faker->numberBetween(0, 15))
                ->setPrice($faker->numberBetween(10000, 500000))
                ->setHeating($faker->numberBetween(0, count(Property::HEATING) -1))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setZipCode($faker->postcode)
                ->setSold(false);
            $manager->persist($property);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
