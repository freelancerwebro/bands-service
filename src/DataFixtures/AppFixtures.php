<?php

namespace App\DataFixtures;

use App\Factory\BandFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $band = BandFactory::createOne();
        $manager->persist($band);
        $manager->flush();
    }
}
