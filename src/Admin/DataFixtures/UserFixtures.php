<?php

namespace App\Admin\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Core\Entity\User;
use App\Admin\Entity\Society;
use App\Admin\Entity\MenuSociety;
use App\Admin\Entity\Menu;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $menu = $manager->getRepository(Menu::class)->findOneBy([]);

        $admin = new User();

        $admin->setName('MultiApp');
        $admin->setEmail('duman.jeanpierre@gmail.com');
        $admin->setName('Jean-Pierre DUMAN');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setAdress('6 avenue gabriel péri 95200 Sarcelles');
        $admin->setPhone('07.86.96.83.89');

        $society = $manager->getRepository(Society::class)->findOneBy([]);

        $admin->setSociety($society);

        $password = $this->encoder->encodePassword($admin, 'bebeto95200.');
        $admin->setPassword($password);

        $menuSociety = new MenuSociety();
        $menuSociety->setMenu($menu);
        $menuSociety->setSociety($society);

        $manager->persist($menuSociety);
        $manager->persist($admin);

        $manager->flush();
    }
}
