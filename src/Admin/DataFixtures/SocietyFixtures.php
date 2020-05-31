<?php

namespace App\Admin\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Admin\Entity\Society;

class SocietyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $society = new Society();

        $society->setName('MultiApp');
        $society->setEnable(true);
        $manager->persist($society);

        $society = new Society();

        $society->setName('Delta RM');
        $society->setEnable(true);
        $manager->persist($society);

        $manager->flush();
    }
}
