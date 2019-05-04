<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $users = [];

        for ($i=0; $i < 10; $i ++)
        {
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail($faker->email);
            $user->setDescription($faker->sentence());
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
            // $product = new Product();
            // $manager->persist($product);
            $manager->persist($user);
            $users[] = $user;
        }

        for($i=0; $i < 25; $i++){
            $property = new Property();
            $user = $users[mt_rand(0, count($users) - 1)];
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
                ->setSold(false)
                ->setLat($faker->latitude)
                ->setLng($faker->longitude)
                ->setAuthor($user);
            $manager->persist($property);
        }

        $manager->flush();
    }
}
