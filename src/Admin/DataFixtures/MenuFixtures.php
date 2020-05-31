<?php

namespace App\Admin\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Admin\Entity\Menu;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $menus = [
            [
                'structure' => 'Paiement',
                'name' => 'Facture'
            ]
        ];

        foreach($menus as $menu) {

            $m = new Menu();
            $m->setStructure($menu['structure']);
            $m->setName($menu['name']);
            $m->setEnable(true);
            $m->setRoute('invoice');

            $manager->persist($m);
        }

        $manager->flush();
    }
}
