<?php

namespace App\Admin\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Core\Entity\User;

class UserExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getDataUser', [$this, 'getDataUser']),
        ];
    }

    public function getDataUser(User $user)
    {
        $array['Société'] = $user->getSociety() !== null ? $user->getSociety()->getName() : null;
        $array['Nom'] = $user->getName() !== '' ? $user->getName() : null;
        $array['Adresse'] = $user->getAdress() !== '' ? $user->getAdress() : null;
        $array['Email'] = $user->getEmail() !== '' ? $user->getEmail() : null;
        $array['Téléphone'] = $user->getPhone() !== '' ? $user->getPhone() : null;

        return $array;
    }
}
