<?php

namespace App\Admin\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Core\Entity\User;

class RightMenuExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getMenus', [$this, 'getMenus']),
        ];
    }

    public function getMenus(User $user)
    {
        $menus = $user->getSociety()->getMenuSocieties();
        $array = [];

        foreach($menus as $item) {
            $array[$item->getMenu()->getStructure()][] = [
                'name' => $item->getMenu()->getName(),
                'route' => $item->getMenu()->getRoute()
            ];
        }

        return $array;
    }
}
