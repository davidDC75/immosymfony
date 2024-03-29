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
        $faker=Factory::create('fr_FR');

        for ($i=0;$i<100;$i++)
        {
            $property=new Property();
            $property
                ->setTitle($faker->words(3,true))
                ->setDescription($faker->sentences(3,true))
                ->setSurface($faker->numberBetween(20,350))
                ->setRooms($faker->numberBetween(2,10))
                ->setBedrooms($faker->numberBetween(1,6))
                ->setFloor($faker->numberBetween(0,20))
                ->setPrice($faker->numberBetween(100000,2000000))
                ->setHeat($faker->numberBetween(0,2))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->numberBetween(10000,99999))
                ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
