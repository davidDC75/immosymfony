<?php

namespace App\DataFixtures;

use App\Entity\Option;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=Factory::create('fr_FR');
        $tblNameOption=[
            0=>'Adapté P.M.R.',
            1=>'Balcon',
            2=>'Jardin',
            3=>'Véranda'
        ];

        foreach ($tblNameOption as $el)
        {
            $option=new option();
            $option
                ->setName($el);
            $manager->persist($option);
        }
        $manager->flush();
    }
}